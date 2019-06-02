<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->decimal('amount_refund')->default(0);
            $table->integer('updated_by')->nullable();
            $table->integer('payment_id')->nullable();
            $table->integer('paypal_id')->nullable();
            $table->integer('free_design_number')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->dropColumn([
                'amount_refund',
                'updated_by',
                'payment_id',
                'free_design_number',
                'paypal_id'
            ]);
        });
    }
}
