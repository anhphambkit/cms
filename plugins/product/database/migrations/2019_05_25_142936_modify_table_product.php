<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyProductTableProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('products', 'weight_dimension_description')) {
            Schema::table('products', function (Blueprint $table) {
                $table->text('weight_dimension_description')->nullable();
            });
        }

        if (!Schema::hasColumn('products', 'specification')) {
            Schema::table('products', function (Blueprint $table) {
                $table->text('specification')->nullable();
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
        if (Schema::hasColumn('products', 'weight_dimension_description')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('weight_dimension_description');
            });
        }

        if (Schema::hasColumn('products', 'specification')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('specification');
            });
        }
    }
}
