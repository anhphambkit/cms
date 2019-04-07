<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->text('avatar')->nullable();
            $table->text('description')->nullable();
            $table->string('gender', 20)->nullable();
            $table->date('dob')->nullable();
            $table->string('phone', 50)->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('secondary_address', 255)->nullable();
            $table->string('job_position', 60)->nullable();
            $table->string('secondary_phone', 20)->nullable();
            $table->string('secondary_email', 60)->nullable();
            $table->string('website', 120)->nullable();
            $table->string('skype', 60)->nullable();
            $table->string('facebook', 120)->nullable();
            $table->string('twitter', 120)->nullable();
            $table->string('google_plus', 120)->nullable();
            $table->string('youtube', 120)->nullable();
            $table->string('github', 120)->nullable();
            $table->string('interest', 255)->nullable();
            $table->string('about', 400)->nullable();
            $table->tinyInteger('status')->unsigned()->default(1);
            $table->rememberToken();
            $table->timestamps();
            
            $table->engine = 'InnoDB';
        });

        Schema::create('customers_password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->nullable();
            $table->engine = 'InnoDB';
        });

        Schema::create('customers_activity_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action', 120);
            $table->text('user_agent')->nullable();
            $table->string('reference_url', 255)->nullable();
            $table->string('reference_name', 255)->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->integer('customer_id')->unsigned()->references('id')->on('customers')->index();
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
        Schema::dropIfExists('customers_activity_logs');
        Schema::dropIfExists('customers_password_resets');
        Schema::dropIfExists('customers');
    }
}
