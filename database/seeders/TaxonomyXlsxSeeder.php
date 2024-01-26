<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\User\Role;
use Maatwebsite\Excel\Facades\Excel;

class TaxonomyXlsxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        \App\Models\Common\TaxonomyMeta::query()->delete();
        \App\Models\Common\Taxonomy::query()->delete();
        Excel::import(new \App\Domains\Admin\Imports\Tables\TaxonomyImport, 'database/imports/taxonomies.xlsx');
        Excel::import(new \App\Domains\Admin\Imports\Tables\TaxonomyMetaImport, 'database/imports/taxonomies.xlsx');

        Schema::enableForeignKeyConstraints();
    }
}
