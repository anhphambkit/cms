<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-29
 * Time: 17:51
 */

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Plugins\Product\Contracts\ProductReferenceConfig;

class DataSettingReferenceSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Database\Eloquent\Model::unguard();

        $now = Carbon::now();

        // Delete + Insert Type Look Book Layout:
        $genders =[
            [
                'value' => ProductReferenceConfig::REFERENCE_LOOK_BOOK_TYPE_LAYOUT_NORMAL,
                'slug' => str_slug(ProductReferenceConfig::REFERENCE_LOOK_BOOK_TYPE_LAYOUT_NORMAL),
                'type' => ProductReferenceConfig::REFERENCE_LOOK_BOOK_TYPE_LAYOUT,
                'order' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'value' => ProductReferenceConfig::REFERENCE_LOOK_BOOK_TYPE_LAYOUT_VERTICAL,
                'slug' => str_slug(ProductReferenceConfig::REFERENCE_LOOK_BOOK_TYPE_LAYOUT_VERTICAL),
                'type' => ProductReferenceConfig::REFERENCE_LOOK_BOOK_TYPE_LAYOUT,
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('references')->where('type', ProductReferenceConfig::REFERENCE_LOOK_BOOK_TYPE_LAYOUT)->delete();
        DB::table('references')->insert($genders);
    }
}
