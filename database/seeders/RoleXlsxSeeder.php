<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\User\Role;
use Maatwebsite\Excel\Facades\Excel;

class RoleXlsxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Role::truncate();
        
        $filename = 'database/imports/roles.xlsx';
        Excel::import(new \App\Domains\Admin\Imports\Tables\RoleImport, $filename);
        
        $filename = 'database/imports/roles.xlsx';
        Excel::import(new \App\Domains\Admin\Imports\Tables\RoleMetaImport, $filename);

        Schema::enableForeignKeyConstraints();
    }
}
