<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Common\Term;
use App\Models\Common\TermMeta;
use Maatwebsite\Excel\Facades\Excel;

class TermXlsxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        
        \App\Models\Common\Term::query()->delete();
        Excel::import(new \App\Domains\Admin\Imports\Tables\TermImport, 'database/imports/terms.xlsx');
        
        \App\Models\Common\TermMeta::query()->delete();
        Excel::import(new \App\Domains\Admin\Imports\Tables\TermMetaImport, 'database/imports/terms.xlsx');

        Schema::enableForeignKeyConstraints();
    }
}
