<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Common\Taxonomy;
use App\Models\Common\TaxonomyMeta;
use App\Imports\TaxonomiesImport;
use App\Imports\TaxonomyMetasImport;
use Maatwebsite\Excel\Facades\Excel;

class TaxonomySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        
        TaxonomyMeta::truncate();
        Taxonomy::truncate();

        // taxonomies
        Excel::import(new TaxonomiesImport, 'database/imports/taxonomies.xlsx');

        // taxonomy meta
        Excel::import(new TaxonomyMetasImport, 'database/imports/taxonomy_metas.xlsx');

        Schema::enableForeignKeyConstraints();
    }
}
