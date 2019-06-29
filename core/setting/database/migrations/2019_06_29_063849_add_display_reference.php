<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisplayReference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('references')) {
            if (!Schema::hasColumn('references', 'display_value')) {
                Schema::table('references', function (Blueprint $table) {
                    $table->text('display_value')->nullable();
                });
            }
            Artisan::call('db:seed', [
                '--class' => UpdateStatusOrder::class,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('references')) {
            Schema::table('references', function (Blueprint $table) {
                $table->dropColumn('display_value');
            });
        }
    }
}
