<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyProductCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('product_categories', 'image_feature')) {
            Schema::table('product_categories', function (Blueprint $table) {
                $table->text('image_feature')->nullable();
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
        if (Schema::hasColumn('product_categories', 'image_feature')) {
            Schema::table('product_categories', function (Blueprint $table) {
                $table->dropColumn('image_feature');
            });
        }
    }
}
