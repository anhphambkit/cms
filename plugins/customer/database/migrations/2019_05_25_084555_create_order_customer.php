<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('address_billing')->nullable();
            $table->text('address_shipping')->nullable();
            $table->integer('status')->nullbale();
            $table->decimal('amount')->default(0);
            $table->text('products')->nullable();
            $table->string('tracking_product_ids')->nullable();
            $table->string('discount_code')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('payment_method')->nullable();
            $table->integer('transaction_id')->nullable();
            $table->string('customer_signature')->nullable();
            $table->text('reason_refund')->nullable();
            $table->integer('customer_id');
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
