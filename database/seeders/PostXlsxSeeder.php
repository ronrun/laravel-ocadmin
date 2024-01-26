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
        
        
        \App\Models\Post\PostMeta::query()->delete();
        \App\Models\Post\Post::query()->delete();
        Excel::import(new \App\Domains\Admin\Imports\Tables\PostImport, 'database/imports/posts.xlsx');
        Excel::import(new \App\Domains\Admin\Imports\Tables\PostMetaImport, 'database/imports/posts.xlsx');

        Schema::enableForeignKeyConstraints();
    }
}
