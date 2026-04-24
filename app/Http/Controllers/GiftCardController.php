<?php

namespace App\Http\Controllers;

use App\Contact;
use App\GiftCard;
use App\GiftCardTransaction;
use App\Transaction;
use App\Utils\TransactionUtil;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GiftCardController extends Controller
{
    /**
     * @var \App\Utils\TransactionUtil
     */
    protected $transactionUtil;

    /**
     * GiftCardController constructor.
     */
    public function __construct(TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }

    /**
     * Display gift cards and issue form.
     */
    public function index(Request $request)
    {
        if (! auth()->user()->can('sell.view') && ! auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = $request->session()->get('user.business_id');
        $query = GiftCard::where('business_id', $business_id)
            ->with(['customer', 'linkedSale'])
            ->orderByDesc('id');

        if ($request->filled('card_number')) {
            $query->where('card_number', 'like', '%'.$request->input('card_number').'%');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $gift_cards = $query->paginate(20)->appends($request->all());
        $customers = Contact::customersDropdown($business_id, false);

        return view('gift_card.index')->with(compact('gift_cards', 'customers'));
    }

    /**
     * Issue a new gift card.
     */
    public function store(Request $request)
    {
        if (! auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'card_number' => 'nullable|string|max:64',
            'contact_id' => 'nullable|integer',
            'issue_amount' => 'required|numeric|min:0.01',
            'bonus_amount' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'note' => 'nullable|string|max:1000',
            'linked_invoice_no' => 'nullable|string|max:191',
            'linked_sale_id' => 'nullable|integer',
        ]);

        try {
            $business_id = $request->session()->get('user.business_id');
            $issue_amount = $this->transactionUtil->num_uf($validated['issue_amount']);
            $bonus_amount = ! empty($validated['bonus_amount']) ? $this->transactionUtil->num_uf($validated['bonus_amount']) : 0;
            $initial_balance = $issue_amount + $bonus_amount;

            if ($initial_balance <= 0) {
                throw new \Exception(__('messages.something_went_wrong'));
            }

            DB::beginTransaction();

            $card_number = ! empty($validated['card_number']) ? strtoupper(trim($validated['card_number'])) : $this->generateCardNumber($business_id);
            if (GiftCard::where('business_id', $business_id)->where('card_number', $card_number)->exists()) {
                throw new \Exception(__('lang_v1.gift_card_number_exists'));
            }

            $linked_sale_id = $this->resolveLinkedSaleIdForIssue(
                $business_id,
                $validated['linked_invoice_no'] ?? null,
                ! empty($validated['linked_sale_id']) ? (int) $validated['linked_sale_id'] : null
            );

            $gift_card = GiftCard::create([
                'business_id' => $business_id,
                'contact_id' => $validated['contact_id'] ?? null,
                'linked_sale_id' => $linked_sale_id,
                'card_number' => $card_number,
                'issue_amount' => $issue_amount,
                'bonus_amount' => $bonus_amount,
                'initial_balance' => $initial_balance,
                'current_balance' => $initial_balance,
                'status' => 'active',
                'expires_at' => ! empty($validated['expires_at']) ? $validated['expires_at'] : null,
                'note' => $validated['note'] ?? null,
                'created_by' => auth()->user()->id,
            ]);

            GiftCardTransaction::create([
                'business_id' => $business_id,
                'gift_card_id' => $gift_card->id,
                'type' => 'issue',
                'amount' => $issue_amount,
                'balance_before' => 0,
                'balance_after' => $issue_amount,
                'note' => __('lang_v1.gift_card_issue_entry'),
                'created_by' => auth()->user()->id,
            ]);

            if ($bonus_amount > 0) {
                GiftCardTransaction::create([
                    'business_id' => $business_id,
                    'gift_card_id' => $gift_card->id,
                    'type' => 'bonus',
                    'amount' => $bonus_amount,
                    'balance_before' => $issue_amount,
                    'balance_after' => $initial_balance,
                    'note' => __('lang_v1.gift_card_bonus_entry'),
                    'created_by' => auth()->user()->id,
                ]);
            }

            DB::commit();

            return redirect()->back()->with('status', [
                'success' => true,
                'msg' => __('lang_v1.gift_card_issued_successfully'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            return redirect()->back()->with('status', [
                'success' => false,
                'msg' => $e->getMessage() ?: __('messages.something_went_wrong'),
            ]);
        }
    }

    /**
     * POS: validate gift card and return current balance for auto-filling payment amount.
     */
    public function lookupBalance(Request $request)
    {
        if (! auth()->user()->can('sell.create') && ! auth()->user()->can('sell.update')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'card_number' => 'required|string|max:64',
        ]);

        try {
            $business_id = $request->session()->get('user.business_id');
            $gift_card = $this->transactionUtil->getValidGiftCardForPayment(
                $business_id,
                $request->input('card_number')
            );

            return response()->json([
                'success' => true,
                'current_balance' => (float) $gift_card->current_balance,
                'card_number' => $gift_card->card_number,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage() ?: __('messages.something_went_wrong'),
            ], 422);
        }
    }

    /**
     * Show gift card transaction history.
     */
    public function show($id)
    {
        if (! auth()->user()->can('sell.view') && ! auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $gift_card = GiftCard::where('business_id', $business_id)
            ->with(['customer', 'linkedSale'])
            ->findOrFail($id);

        $transactions = GiftCardTransaction::where('gift_card_id', $gift_card->id)
            ->with(['transaction'])
            ->orderByDesc('id')
            ->paginate(25);

        return view('gift_card.show')->with(compact('gift_card', 'transactions'));
    }

    /**
     * Toggle status between active and inactive.
     */
    public function toggleStatus($id)
    {
        if (! auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
        $gift_card = GiftCard::where('business_id', $business_id)->findOrFail($id);

        if ($gift_card->status === 'expired') {
            return redirect()->back()->with('status', [
                'success' => false,
                'msg' => __('lang_v1.gift_card_expired_cannot_activate'),
            ]);
        }

        $gift_card->status = $gift_card->status === 'active' ? 'inactive' : 'active';
        $gift_card->save();

        return redirect()->back()->with('status', [
            'success' => true,
            'msg' => __('lang_v1.gift_card_status_updated'),
        ]);
    }

    /**
     * Resolve internal sale id from invoice/reference text (e.g. "0006") or legacy numeric id.
     *
     * @param  int|null  $legacySaleId  optional direct transactions.id (backward compatible)
     * @return int|null
     */
    protected function resolveLinkedSaleIdForIssue($business_id, $invoiceOrRef, $legacySaleId = null)
    {
        $ref = is_string($invoiceOrRef) ? trim($invoiceOrRef) : '';
        if ($ref !== '') {
            $sale = Transaction::where('business_id', $business_id)
                ->where('type', 'sell')
                ->whereIn('status', ['final', 'completed'])
                ->where(function ($q) use ($ref) {
                    $q->where('invoice_no', $ref)->orWhere('ref_no', $ref);
                    $stripped = ltrim($ref, '0');
                    if ($stripped !== '' && $stripped !== $ref) {
                        $q->orWhere('invoice_no', $stripped)->orWhere('ref_no', $stripped);
                    }
                })
                ->orderByDesc('id')
                ->first();
            if (empty($sale)) {
                throw new \Exception(__('lang_v1.gift_card_invoice_not_found', ['invoice' => $ref]));
            }

            return (int) $sale->id;
        }

        if (! empty($legacySaleId)) {
            $sale = Transaction::where('business_id', $business_id)
                ->where('id', $legacySaleId)
                ->where('type', 'sell')
                ->whereIn('status', ['final', 'completed'])
                ->first();
            if (empty($sale)) {
                throw new \Exception(__('lang_v1.gift_card_invalid_linked_sale'));
            }

            return (int) $sale->id;
        }

        return null;
    }

    /**
     * Generate unique card number for business.
     */
    protected function generateCardNumber($business_id)
    {
        do {
            $number = 'GC-'.strtoupper(Str::random(10));
        } while (GiftCard::where('business_id', $business_id)->where('card_number', $number)->exists());

        return $number;
    }
}
