<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Catalog\Product;
use App\Models\Catalog\ProductMeta;
use App\Imports\ProductsImport;
use App\Imports\ProductMetasImport;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        
        ProductMeta::truncate();
        Product::truncate();

        // products
        $filename = 'database/imports/products.xlsx';
        Excel::import(new ProductsImport, $filename);

        // products translations
        $filename = 'database/imports/product_metas.xlsx';
        Excel::import(new ProductMetasImport, $filename);

        Schema::enableForeignKeyConstraints();
    }
}
