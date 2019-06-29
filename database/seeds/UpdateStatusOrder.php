<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Plugins\Customer\Contracts\OrderReferenceConfig;

class UpdateStatusOrder extends Seeder
{
    /**
     * Run the database seeds.
     * Artisan::call('db:seed', [
		    '--class' => 'UpdateStatusOrder'
		]);
     * @return void
     */
    public function run()
    {
        \Illuminate\Database\Eloquent\Model::unguard();

        $references = [
			OrderReferenceConfig::REFERENCE_ORDER_STATUS_NEW       => OrderReferenceConfig::REFERENCE_ORDER_DISPLAY_STATUS_NEW,
			OrderReferenceConfig::REFERENCE_ORDER_STATUS_PENDING   => OrderReferenceConfig::REFERENCE_ORDER_DISPLAY_STATUS_PENDING,
			OrderReferenceConfig::REFERENCE_ORDER_STATUS_OPEN      => OrderReferenceConfig::REFERENCE_ORDER_DISPLAY_STATUS_OPEN,
			OrderReferenceConfig::REFERENCE_ORDER_STATUS_SHIPPED   => OrderReferenceConfig::REFERENCE_ORDER_DISPLAY_STATUS_SHIPPED,
			OrderReferenceConfig::REFERENCE_ORDER_STATUS_CANCEL    => OrderReferenceConfig::REFERENCE_ORDER_DISPLAY_STATUS_CANCEL,
			OrderReferenceConfig::REFERENCE_ORDER_STATUS_REFUND    => OrderReferenceConfig::REFERENCE_ORDER_DISPLAY_STATUS_REFUND,
			OrderReferenceConfig::REFERENCE_ORDER_STATUS_DELIVERED => OrderReferenceConfig::REFERENCE_ORDER_DISPLAY_STATUS_DELIVERED,
        ];

        foreach ($references as $reference => $displayName) {
        	$filters = [
        		'type' => OrderReferenceConfig::REFERENCE_ORDER_STATUS,
        		'value' => $reference
        	];

        	DB::table('references')->where($filters)->update([
        		'display_value' => $displayName
        	]);
        }
        print_r("\nRun migrate order display name success.");
    }
}
