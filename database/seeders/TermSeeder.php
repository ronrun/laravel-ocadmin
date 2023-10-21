<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Common\Term;
use App\Models\Common\TermMeta;
use App\Imports\TermsImport;
use App\Imports\TermMetasImport;
use Maatwebsite\Excel\Facades\Excel;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        
        TermMeta::truncate();
        Term::truncate();

        // terms
        Excel::import(new TermsImport, 'database/imports/terms.xlsx');

        // term meta
        //Excel::import(new TermMetasImport, 'database/imports/term_metas.xlsx');

        Schema::enableForeignKeyConstraints();
    }
}
