<?php

namespace App\Console\Commands;

use App\Business;
use App\PurchaseLine;
use App\Transaction;
use App\Utils\Util;
use App\VariationLocationDetails;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class AutoGenerateRestockRequisitions extends Command
{
    protected $commonUtil;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pos:autoGenerateRestockRequisitions {--business_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto create purchase requisitions for low stock products based on business settings.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Util $commonUtil)
    {
        parent::__construct();
        $this->commonUtil = $commonUtil;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '512M');

            $business_query = Business::query();
            if (! empty($this->option('business_id'))) {
                $business_query->where('id', $this->option('business_id'));
            }

            $businesses = $business_query->get();
            $created_requisitions = 0;

            foreach ($businesses as $business) {
                $created_requisitions += $this->generateForBusiness($business);
            }

            $this->info("Auto restock complete. Requisitions created: {$created_requisitions}");
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());
            $this->error($e->getMessage());

            return 1;
        }

        return 0;
    }

    /**
     * Generate auto restock requisitions for a business.
     *
     * @return int Number of requisitions created
     */
    protected function generateForBusiness($business)
    {
        $common_settings = ! empty($business->common_settings) ? $business->common_settings : [];

        if (array_key_exists('enable_auto_restock', $common_settings) && empty($common_settings['enable_auto_restock'])) {
            return 0;
        }

        if (! array_key_exists('enable_auto_restock', $common_settings)) {
            return 0;
        }

        if (array_key_exists('enable_purchase_requisition', $common_settings) && empty($common_settings['enable_purchase_requisition'])) {
            return 0;
        }

        $target_factor = (float) ($common_settings['auto_restock_target_factor'] ?? 1);
        $target_factor = $target_factor < 1 ? 1 : $target_factor;

        $delivery_offset_days = (int) ($common_settings['auto_restock_delivery_days'] ?? 0);
        $delivery_offset_days = $delivery_offset_days < 0 ? 0 : $delivery_offset_days;

        $low_stock_products = VariationLocationDetails::join(
            'products as p',
            'variation_location_details.product_id',
            '=',
            'p.id'
        )
            ->where('p.business_id', $business->id)
            ->where('p.enable_stock', 1)
            ->where('p.is_inactive', 0)
            ->whereNotNull('p.alert_quantity')
            ->whereRaw('variation_location_details.qty_available <= p.alert_quantity')
            ->select(
                'variation_location_details.location_id',
                'variation_location_details.variation_id',
                'variation_location_details.product_id',
                'variation_location_details.qty_available',
                'p.alert_quantity'
            )
            ->get();

        if ($low_stock_products->isEmpty()) {
            return 0;
        }

        $lines_by_location = [];

        foreach ($low_stock_products as $item) {
            $pending_requisition_qty = (float) PurchaseLine::join(
                'transactions as t',
                'purchase_lines.transaction_id',
                '=',
                't.id'
            )
                ->where('t.business_id', $business->id)
                ->where('t.type', 'purchase_requisition')
                ->whereIn('t.status', ['ordered', 'partial'])
                ->where('t.location_id', $item->location_id)
                ->where('purchase_lines.variation_id', $item->variation_id)
                ->sum('purchase_lines.quantity');

            $target_stock = ((float) $item->alert_quantity) * $target_factor;
            $requisition_qty = $target_stock - ((float) $item->qty_available + $pending_requisition_qty);

            if ($requisition_qty <= 0) {
                continue;
            }

            $lines_by_location[$item->location_id][] = [
                'variation_id' => $item->variation_id,
                'product_id' => $item->product_id,
                'quantity' => $requisition_qty,
                'purchase_price_inc_tax' => 0,
                'item_tax' => 0,
            ];
        }

        if (empty($lines_by_location)) {
            return 0;
        }

        $created_count = 0;
        $created_by = ! empty($business->owner_id) ? $business->owner_id : 1;

        foreach ($lines_by_location as $location_id => $purchase_lines) {
            DB::transaction(function () use ($business, $created_by, $location_id, $purchase_lines, $delivery_offset_days, &$created_count) {
                $ref_count = $this->commonUtil->setAndGetReferenceCount('purchase_requisition', $business->id);
                $ref_no = $this->commonUtil->generateReferenceNumber('purchase_requisition', $ref_count, $business->id);

                $transaction_data = [
                    'business_id' => $business->id,
                    'location_id' => $location_id,
                    'type' => 'purchase_requisition',
                    'status' => 'ordered',
                    'created_by' => $created_by,
                    'transaction_date' => Carbon::now()->toDateTimeString(),
                    'delivery_date' => $delivery_offset_days > 0 ? Carbon::now()->addDays($delivery_offset_days)->toDateTimeString() : null,
                    'ref_no' => $ref_no,
                    'sub_type' => 'auto_restock',
                ];

                $requisition = Transaction::create($transaction_data);
                $requisition->purchase_lines()->createMany($purchase_lines);
                $created_count++;
            });
        }

        return $created_count;
    }
}
