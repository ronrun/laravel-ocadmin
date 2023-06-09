<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxonomySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Taxonomy
        $filename = 'database/imports/taxonomies.csv';

        $query = "LOAD DATA LOCAL INFILE '".$filename."' INTO TABLE taxonomies
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\r\n'
            IGNORE 1 LINES
            (id,code,is_active,created_at,updated_at);";
             
        DB::unprepared($query);

        // Taxonomy Translations
        $filename = 'database/imports/taxonomy_translations.csv';

        $query = "LOAD DATA LOCAL INFILE '".$filename."' INTO TABLE taxonomy_translations
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\r\n'
            IGNORE 1 LINES
            (id,taxonomy_id,locale,name);";
             
        DB::unprepared($query);
    }
}
