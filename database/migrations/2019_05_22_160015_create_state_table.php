<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('code', 10);
            $table->timestamps();
        });

        $this->seedDB();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }

    /**
     * [seedDB description]
     * @return [type] [description]
     */
    public function seedDB()
    {
        Model::unguard();

        $states = [
            [ 'id' => 1,'name' => 'Alabama','code' => 'AL'],
            [ 'id' => 2,'name' => 'Alaska','code' => 'AK'],
            [ 'id' => 3,'name' => 'American Samoa','code' => 'AS'],
            [ 'id' => 4,'name' => 'Arizona','code' => 'AZ'],
            [ 'id' => 5,'name' => 'Arkansas','code' => 'AR'],
            [ 'id' => 6,'name' => 'California','code' => 'CA'],
            [ 'id' => 7,'name' => 'Colorado','code' => 'CO'],
            [ 'id' => 8,'name' => 'Connecticut','code' => 'CT'],
            [ 'id' => 9,'name' => 'Delaware','code' => 'DE'],
            [ 'id' => 10,'name' => 'District of Columbia','code' => 'DC'],
            [ 'id' => 11,'name' => 'Florida','code' => 'FL'],
            [ 'id' => 12,'name' => 'Georgia','code' => 'GA'],
            [ 'id' => 13,'name' => 'Guam','code' => 'GU'],
            [ 'id' => 14,'name' => 'Hawaii','code' => 'HI'],
            [ 'id' => 15,'name' => 'Idaho','code' => 'ID'],
            [ 'id' => 16,'name' => 'Illinois','code' => 'IL'],
            [ 'id' => 17,'name' => 'Indiana','code' => 'IN'],
            [ 'id' => 18,'name' => 'Iowa','code' => 'IA'],
            [ 'id' => 19,'name' => 'Kansas','code' => 'KS'],
            [ 'id' => 20,'name' => 'Kentucky','code' => 'KY'],
            [ 'id' => 21,'name' => 'Louisiana','code' => 'LA'],
            [ 'id' => 22,'name' => 'Maine','code' => 'ME'],
            [ 'id' => 23,'name' => 'Marshall Islands','code' => 'MH'],
            [ 'id' => 24,'name' => 'Maryland','code' => 'MD'],
            [ 'id' => 25,'name' => 'Massachusetts','code' => 'MA'],
            [ 'id' => 26,'name' => 'Michigan','code' => 'MI'],
            [ 'id' => 27,'name' => 'Federated States of Micronesia','code' => 'FM'],
            [ 'id' => 28,'name' => 'Minnesota','code' => 'MN'],
            [ 'id' => 29,'name' => 'Mississippi','code' => 'MS'],
            [ 'id' => 30,'name' => 'Missouri','code' => 'MO'],
            [ 'id' => 31,'name' => 'Montana','code' => 'MT'],
            [ 'id' => 32,'name' => 'Nebraska','code' => 'NE'],
            [ 'id' => 33,'name' => 'Nevada','code' => 'NV'],
            [ 'id' => 34,'name' => 'New Hampshire','code' => 'NH'],
            [ 'id' => 35,'name' => 'New Jersey','code' => 'NJ'],
            [ 'id' => 36,'name' => 'New Mexico','code' => 'NM'],
            [ 'id' => 37,'name' => 'New York','code' => 'NY'],
            [ 'id' => 38,'name' => 'North Carolina','code' => 'NC'],
            [ 'id' => 39,'name' => 'North Dakota','code' => 'ND'],
            [ 'id' => 40,'name' => 'Northern Mariana Islands','code' => 'MP'],
            [ 'id' => 41,'name' => 'Ohio','code' => 'OH'],
            [ 'id' => 42,'name' => 'Oklahoma','code' => 'OK'],
            [ 'id' => 43,'name' => 'Oregon','code' => 'OR'],
            [ 'id' => 44,'name' => 'Palau','code' => 'PW'],
            [ 'id' => 45,'name' => 'Pennsylvania','code' => 'PA'],
            [ 'id' => 46,'name' => 'Puerto Rico','code' => 'PR'],
            [ 'id' => 47,'name' => 'Rhode Island','code' => 'RI'],
            [ 'id' => 48,'name' => 'South Carolina','code' => 'SC'],
            [ 'id' => 49,'name' => 'South Dakota','code' => 'SD'],
            [ 'id' => 50,'name' => 'Tennessee','code' => 'TN'],
            [ 'id' => 51,'name' => 'Texas','code' => 'TX'],
            [ 'id' => 52,'name' => 'Utah','code' => 'UT'],
            [ 'id' => 53,'name' => 'Vermont','code' => 'VT'],
            [ 'id' => 54,'name' => 'Virgin Islands','code' => 'VI'],
            [ 'id' => 55,'name' => 'Virginia','code' => 'VA'],
            [ 'id' => 56,'name' => 'Washington','code' => 'WA'],
            [ 'id' => 57,'name' => 'West Virginia','code' => 'WV'],
            [ 'id' => 58,'name' => 'Wisconsin','code' => 'WI'],
            [ 'id' => 59,'name' => 'Wyoming','code' => 'WY'],
        ];

        $now = new Carbon();
        foreach ($states as $state){
            $state['created_at'] = $now->now();
            $state['updated_at'] = $now->now();
            DB::table('states')->insert($state);
        }
    }
}
