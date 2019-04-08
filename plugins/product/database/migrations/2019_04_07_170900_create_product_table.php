<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();

        Schema::create('product_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('brand_image', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('product_colors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('code', 20)->unique();
            $table->string('description')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('product_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('slug', 150)->unique();
            $table->string('description')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('product_materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('slug', 150);
            $table->string('description')->nullable();
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('product_business_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('slug', 150)->unique()->comment('Slug of business type');
            $table->integer('parent_id')->default(0)->comment('Id of business type parent');
            $table->string('description')->nullable();
            $table->integer('order')->default(0)->comment('Order of this business type (Just on the same level).');
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('product_business_types_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_business_type_id');
            $table->integer('product_id');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120)->unique();
            $table->string('slug', 150)->unique()->comment('Slug of category');
            $table->integer('parent_id')->default(0)->comment('Id of category parent');
            $table->string('description')->nullable();
            $table->integer('order')->default(0)->comment('Order of this category (Just on the same level).');
            $table->boolean('status')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('product_categories_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_category_id');
            $table->integer('product_id');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('slug', 150);
            $table->string('upc', 150)->unique();
            $table->string('sku', 30);
            $table->string('short_description', 255)->nullable();
            $table->text('long_desc')->nullable();
            $table->boolean('is_feature')->default(false)->comment('Product feature');
            $table->boolean('is_best_seller')->default(false)->comment('Product is best seller');
            $table->boolean('is_free_ship')->default(false)->comment('Product is free ship');
            $table->boolean('has_design')->default(false)->comment('Product has free design');
            $table->boolean('has_assembly')->default(false)->comment('Product has assembly');
            $table->string('product_dimension', 30)->nullable()->comment('Product dimension WxDxH');
            $table->string('package_dimension', 30)->nullable()->comment('Package dimension WxDxH');
            $table->integer('product_weight')->nullable()->comment('Product weight');
            $table->integer('package_weight')->nullable()->comment('Package weight');
            $table->integer('price')->comment('Original price'); // Original price
            $table->integer('sale_price')->nullable()->comment('Sale Price'); // Price which client will pay to buy
            $table->integer('in_stock')->nullable()->comment('Total items in stock'); // Original price
            $table->integer('rating')->default(5)->comment('Number of star for this product.');
            $table->string('keywords')->nullable();
            $table->boolean('status')->unsigned()->default(1)->comment('true: Published, false: Draft');

            $table->softDeletes();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_brands');
        Schema::dropIfExists('product_colors');
        Schema::dropIfExists('product_collections');
        Schema::dropIfExists('product_materials');
        Schema::dropIfExists('product_business_types');
        Schema::dropIfExists('product_business_types_relation');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('product_categories_relation');
        Schema::dropIfExists('products');
    }
}
