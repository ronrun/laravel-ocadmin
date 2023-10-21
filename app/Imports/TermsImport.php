<?php

namespace App\Imports;

use App\Models\Common\Term;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class TermsImport implements ToModel,WithStartRow,ToCollection
{
    public function model(array $row)
    {
        return new Term([
            'id' => $row[0],
            'parent_id' => $row[1],
            'taxonomy_id' => $row[2],
            'taxonomy_code' => $row[3],
            'is_active' => $row[4],
            'created_at' => $row[5],
            'updated_at' => $row[6],
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }


    public function collection(Collection $rows)
    {}
}
