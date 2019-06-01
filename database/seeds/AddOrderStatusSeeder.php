<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Plugins\Customer\Contracts\OrderReferenceConfig;
class AddOrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Artisan::call('db:seed', [
		    '--class' => 'AddOrderStatusSeeder'
		]);
     * @return void
     */
    public function run()
    {
        \Illuminate\Database\Eloquent\Model::unguard();

        $references = [
        	OrderReferenceConfig::REFERENCE_ORDER_STATUS_NEW,
			OrderReferenceConfig::REFERENCE_ORDER_STATUS_PENDING,
			OrderReferenceConfig::REFERENCE_ORDER_STATUS_OPEN,
			OrderReferenceConfig::REFERENCE_ORDER_STATUS_SHIPPED,
			OrderReferenceConfig::REFERENCE_ORDER_STATUS_CANCEL,
			OrderReferenceConfig::REFERENCE_ORDER_STATUS_REFUND,
        ];

        foreach ($references as $reference) {
        	$exists = DB::table('references')
        		->where('type', OrderReferenceConfig::REFERENCE_ORDER_STATUS)
        		->where('value', $reference)
        		->exists();

        	if(!$exists){
        		DB::table('references')->insert([
					'type'       => OrderReferenceConfig::REFERENCE_ORDER_STATUS,
					'value'      => $reference,
					'slug'       => str_slug($reference),
					'order'      => 0,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now(),
        		]);
        		print_r("\nInsert new reference with value : {$reference}");
        	}
        }
        print_r("\n");
    }
}