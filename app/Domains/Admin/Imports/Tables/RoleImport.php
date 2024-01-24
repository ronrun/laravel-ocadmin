<?php

namespace App\Domains\Admin\Imports\Tables;

use App\Models\User\Role;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class RoleImport implements ToModel,WithStartRow,WithMultipleSheets 
{
    public function model(array $row)
    {
        $rows = new Role([
            'id'            => $row[0],
            'name'          => $row[1],
            'guard_name'   => $row[2],
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);

        return $rows;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function sheets(): array
    {
        return [
            'roles' => $this,
        ];
    }
}
