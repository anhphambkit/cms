<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Plugins\Product\Contracts\ProductReferenceConfig;

class ModifyWishListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('wish_list', 'entity_type')) {
            Schema::table('wish_list', function (Blueprint $table) {
                $table->renameColumn('product_id', 'entity_id');
                $table->string('entity_type')->default(ProductReferenceConfig::ENTITY_TYPE_PRODUCT);
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
        if (Schema::hasColumn('wish_list', 'entity_type')) {
            Schema::table('wish_list', function (Blueprint $table) {
                $table->renameColumn('entity_id', 'product_id');
                $table->dropColumn('entity_type');
            });
        }
    }
}
