<?php

namespace App\Imports;

use App\Models\Common\TaxonomyMeta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class TaxonomyMetasImport implements ToModel,WithStartRow,ToCollection
{
    public function model(array $row)
    {
        return new TaxonomyMeta([
           'taxonomy_id'    => $row[0],
           'locale'         => $row[1], 
           'meta_key'       => $row[2],
           'meta_value'     => $row[3],
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }

    public function collection(Collection $rows)
    {}
}
