<?php

namespace App\Imports;

use App\Models\Common\Taxonomy;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class TaxonomiesImport implements ToModel,WithStartRow,ToCollection
{
    public function model(array $row)
    {
        return new Taxonomy([
            'id' => $row[0],
            'code' => $row[1],
            'model' => $row[2],
            'is_active' => $row[3],
            'created_at' => $row[4],
            'updated_at' => $row[5],
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }


    public function collection(Collection $rows)
    {}
}
