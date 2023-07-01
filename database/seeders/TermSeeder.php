<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // terms
        $filename = 'database/imports/terms.csv';

        $query = "LOAD DATA LOCAL INFILE '".$filename."' INTO TABLE terms
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\r\n'
            IGNORE 1 LINES
            (id,parent_id,taxonomy_code,is_active,created_at,updated_at);";
             
        DB::unprepared($query);

        // term_translations
        $filename = 'database/imports/term_translations.csv';

        $query = "LOAD DATA LOCAL INFILE '".$filename."' INTO TABLE term_translations
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\r\n'
            IGNORE 1 LINES
            (id,term_id,locale,name);";
             
        DB::unprepared($query);

        // term_metas
        $filename = 'database/imports/term_metas.csv';

        $query = "LOAD DATA LOCAL INFILE '".$filename."' INTO TABLE term_metas
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\r\n'
            IGNORE 1 LINES
            (id,term_id,meta_key,meta_value);";
             
        DB::unprepared($query);
    }
}
