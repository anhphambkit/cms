<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnPaypalId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('payment_transactions', 'paypal_id')) {
            Schema::table('payment_transactions', function (Blueprint $table) {
                $table->string('paypal_id')->nullable();
            });
        }
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('payment_transactions', 'paypal_id')) {
            Schema::table('payment_transactions', function (Blueprint $table) {
                $table->dropColumn('paypal_id');
            });
        }
    }
}
