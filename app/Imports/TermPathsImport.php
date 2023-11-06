<?php

namespace App\Imports;

use App\Models\Common\TermPath;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class TermPathsImport implements ToModel,WithStartRow,ToCollection
{
    public function model(array $row)
    {
        return new TermPath([
            'term_id'  => $row[0],
            'path_id'  => $row[1],
            'level'    => $row[2],
            'group_id' => $row[3],
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }


    public function collection(Collection $rows)
    {}
}
