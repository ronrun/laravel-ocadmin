<?php

namespace App\Domains\Admin\Imports\Tables;

use App\Models\Common\TaxonomyMeta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TaxonomyMetaImport implements ToModel,WithStartRow,WithMultipleSheets 
{
    public function model(array $row)
    {
        $rows = new TaxonomyMeta([
            'id'            => $row[0],
            'locale'        => $row[1],
            'taxonomy_id' => $row[2],
            'meta_key'      => $row[3],
            'meta_value'    => $row[4],
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
            'taxonomy_metas' => $this,
        ];
    }
}
