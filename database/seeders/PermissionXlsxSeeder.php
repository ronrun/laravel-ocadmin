<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\User\Permission;
use Maatwebsite\Excel\Facades\Excel;

class PermissionXlsxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Permission::truncate();
        
        $filename = 'database/imports/permissions.xlsx';
        Excel::import(new \App\Domains\Admin\Imports\Tables\PermissionImport, $filename);
        
        $filename = 'database/imports/permissions.xlsx';
        Excel::import(new \App\Domains\Admin\Imports\Tables\PermissionMetaImport, $filename);

        Schema::enableForeignKeyConstraints();
    }
}
