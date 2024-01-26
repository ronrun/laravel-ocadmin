<?php

namespace App\Domains\Admin\Imports\Tables;

use App\Models\Common\Taxonomy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PostImport implements ToModel,WithStartRow,WithMultipleSheets 
{
    public function model(array $row)
    {
        $rows = new Taxonomy([
            'id'            => $row[0],
            'code'          => $row[1],
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
            'posts' => $this,
        ];
    }
}
