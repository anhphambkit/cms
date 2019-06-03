<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTableOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('customer_orders');
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->boolean('is_guest')->default(true);
            $table->text('address_billing')->nullable();
            $table->text('address_shipping')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('payment_method');
            $table->float('total_original_price');
            $table->float('total_amount_order');
            $table->float('discount_price')->nullable();
            $table->float('shipping_fee')->nullable();
            $table->float('total_price');
            $table->float('total_sale_price_on_products');
            $table->float('saved_price');
            $table->string('coupon_code')->nullable();
            $table->boolean('is_free_shipping')->default(false);
            $table->boolean('status')->default(true);
            $table->string('tracking_product_ids')->nullable();
            $table->string('tracking_number')->nullable();
            $table->integer('transaction_id')->nullable();
            $table->string('customer_signature')->nullable();
            $table->text('reason_refund')->nullable();
            $table->decimal('amount_refund')->default(0);
            $table->integer('updated_by')->nullable();
            $table->integer('payment_id')->nullable();
            $table->integer('payal_id')->nullable();
            $table->integer('total_free_design')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_orders');
    }
}
