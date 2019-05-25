<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTableProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('products', 'parent_product_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('parent_product_id')->nullable();
            });
        }

        Schema::create('product_business_type_space_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_type_id');
            $table->integer('space_id');
            $table->integer('product_id');
            $table->boolean('apply_all')->default(false);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        if (Schema::hasColumn('products', 'parent_product_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('parent_product_id');
            });
        }

        Schema::dropIfExists('product_business_type_space_relation');
    }
}
