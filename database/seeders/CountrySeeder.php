<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->truncate();

        $filename = 'database/imports/countries.csv';

        $query = "LOAD DATA LOCAL INFILE '".$filename."' INTO TABLE countries
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\r\n'
            IGNORE 0 LINES
            (id,name,native_name,iso_code_2,iso_code_3,is_active);";
    
        DB::unprepared($query);
    }
}
