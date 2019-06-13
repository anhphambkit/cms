<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCouponToCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('cart', 'coupon_id')) {
            Schema::table('cart', function (Blueprint $table) {
                $table->integer('coupon_id')->nullable();
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
        if (Schema::hasColumn('cart', 'coupon_id')) {
            Schema::table('cart', function (Blueprint $table) {
                $table->dropColumn('coupon_id');
            });
        }
    }
}
