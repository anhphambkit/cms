<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateSaleProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('products', 'sale_start_date')) {
            Schema::table('products', function (Blueprint $table) {
                $table->date('sale_start_date')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'sale_end_date')) {
            Schema::table('products', function (Blueprint $table) {
                $table->date('sale_end_date')->nullable();
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
        if (Schema::hasColumn('products', 'sale_start_date')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('sale_start_date');
            });
        }

        if (Schema::hasColumn('products', 'sale_end_date')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('sale_end_date');
            });
        }
    }
}
