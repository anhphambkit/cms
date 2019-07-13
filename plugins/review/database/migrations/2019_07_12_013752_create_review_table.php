<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Core\User\Models\User;

class CreateReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->integer('product_id');
            $table->text('content');
            $table->integer('rating')->default(0);
            $table->tinyInteger('status')->unsigned()->default(1);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('product_review_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->integer('review_id');
            $table->integer('author_id');
            $table->string('author_type', 255)->default(addslashes(User::class));
            $table->tinyInteger('status')->unsigned()->default(1);
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
        Schema::dropIfExists('product_reviews');
        Schema::dropIfExists('product_review_comments');
    }
}
