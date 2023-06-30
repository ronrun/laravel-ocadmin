<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Taxonomy
        $filename = 'database/imports/products.csv';

        $query = "LOAD DATA LOCAL INFILE '".$filename."' INTO TABLE products
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\r\n'
            IGNORE 1 LINES
            (id,is_active,created_at,updated_at);";
             
        DB::unprepared($query);

        // Taxonomy Translations
        $filename = 'database/imports/product_translations.csv';

        $query = "LOAD DATA LOCAL INFILE '".$filename."' INTO TABLE product_translations
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\r\n'
            IGNORE 1 LINES
            (id,product_id,locale,name);";
             
        DB::unprepared($query);
    }
}
