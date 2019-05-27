<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAttribute extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_value_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('attribute_id');
            $table->integer('attribute_value_id');
            $table->timestamps();
        });

        if (!Schema::hasColumn('products', 'type_product')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('type_product')->default('simple')->comment('simple|variant');
            });
        }

        if (!Schema::hasColumn('products', 'parent_linked_product')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('parent_linked_product')->nullable();
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
        Schema::dropIfExists('product_attribute_value_relations');

        if (Schema::hasColumn('products', 'type_product')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('type_product');
            });
        }

        if (Schema::hasColumn('products', 'parent_linked_product')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('parent_linked_product');
            });
        }
    }
}
