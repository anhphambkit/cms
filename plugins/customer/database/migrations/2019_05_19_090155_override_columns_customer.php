<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OverrideColumnsCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('customers', 'first_name')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('first_name')->nullable()->change();
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
        if (Schema::hasColumn('customers', 'first_name')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->string('first_name')->nullable(false)->change();
            });
        }
    }
}
