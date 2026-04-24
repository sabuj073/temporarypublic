<?php

namespace App\Http\Controllers;

use App\Contact;
use App\LoyaltyPointLedger;
use App\LoyaltyTier;
use App\Transaction;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class LoyaltyAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $business_id = $request->session()->get('user.business_id');
        $start_date = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $end_date = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $ledger_query = LoyaltyPointLedger::where('business_id', $business_id)
            ->whereBetween(DB::raw('date(created_at)'), [$start_date, $end_date]);

        $points_earned = (clone $ledger_query)->where('entry_type', 'earned')->sum('points');
        $points_redeemed = (clone $ledger_query)->where('entry_type', 'redeemed')->sum('points');

        $tier_customers = Contact::leftJoin('loyalty_tiers', 'contacts.loyalty_tier_id', '=', 'loyalty_tiers.id')
            ->where('contacts.business_id', $business_id)
            ->whereIn('contacts.type', ['customer', 'both'])
            ->select(
                DB::raw("COALESCE(loyalty_tiers.name, 'Unassigned') as tier_name"),
                DB::raw('COUNT(contacts.id) as total_customers')
            )
            ->groupBy('tier_name')
            ->get();

        $tier_sales = Transaction::leftJoin('contacts', 'transactions.contact_id', '=', 'contacts.id')
            ->leftJoin('loyalty_tiers', 'contacts.loyalty_tier_id', '=', 'loyalty_tiers.id')
            ->where('transactions.business_id', $business_id)
            ->where('transactions.type', 'sell')
            ->where('transactions.status', 'final')
            ->whereBetween(DB::raw('date(transactions.transaction_date)'), [$start_date, $end_date])
            ->select(
                DB::raw("COALESCE(loyalty_tiers.name, 'Unassigned') as tier_name"),
                DB::raw('SUM(transactions.final_total) as total_sales')
            )
            ->groupBy('tier_name')
            ->get();

        $tiers = LoyaltyTier::where('business_id', $business_id)->orderBy('level')->get();

        return view('report.loyalty_analytics', compact(
            'start_date',
            'end_date',
            'points_earned',
            'points_redeemed',
            'tier_customers',
            'tier_sales',
            'tiers'
        ));
    }
}
