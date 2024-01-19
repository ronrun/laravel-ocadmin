<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
//use Illuminate\Support\Facades\DB;
use App\Models\Sysdata\Country;
use App\Domains\Admin\Imports\CountriesImport;
use Maatwebsite\Excel\Facades\Excel;

class CountryXlsxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        
        Country::truncate();

        // products
        $filename = 'database/imports/countries.xlsx';
        Excel::import(new CountriesImport, $filename);

        Schema::enableForeignKeyConstraints();
    }
}
