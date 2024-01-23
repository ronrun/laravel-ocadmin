<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
//use Illuminate\Support\Facades\DB;
use App\Models\Sysdata\Language;
use App\Domains\Admin\Imports\Tables\LanguageImport;
use Maatwebsite\Excel\Facades\Excel;

class LanguageXlsxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        
        Language::truncate();

        $filename = 'database/imports/countries.xlsx';
        Excel::import(new LanguageImport, $filename);

        Schema::enableForeignKeyConstraints();
    }
}
