<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('zones')->truncate();

        $filename = 'database/imports/zones.csv';

        $query = "LOAD DATA LOCAL INFILE '".$filename."' INTO TABLE zones
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\r\n'
            IGNORE 0 LINES
            (id,country_id,name,code,is_active);";
    
        DB::unprepared($query);
    }
}
