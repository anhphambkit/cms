<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyLooBookTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('look_book_tags', 'left')) {
            Schema::table('look_book_tags', function (Blueprint $table) {
                $table->string('left')->change();
            });
        }

        if (Schema::hasColumn('look_book_tags', 'top')) {
            Schema::table('look_book_tags', function (Blueprint $table) {
                $table->string('top')->change();
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
        if (Schema::hasColumn('look_book_tags', 'left')) {
            Schema::table('look_book_tags', function (Blueprint $table) {
                $table->float('left', 3, 2)->change();
            });
        }

        if (Schema::hasColumn('look_book_tags', 'top')) {
            Schema::table('look_book_tags', function (Blueprint $table) {
                $table->float('top', 3, 2)->change();
            });
        }
    }
}
