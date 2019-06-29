<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnActionProductOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_in_order', function (Blueprint $table) {
            $table->boolean('is_cancel')->default(false);
            $table->boolean('is_return')->default(false);
            $table->boolean('is_replace')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_in_order', function (Blueprint $table) {
            $table->dropColumn([
                'is_cancel',
                'is_return',
                'is_replace'
            ]);
        });
    }
}
