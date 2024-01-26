<?php

namespace App\Domains\Admin\Imports\Tables;

use App\Models\Common\TermMeta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TermMetaImport implements ToModel,WithStartRow,WithMultipleSheets 
{
    public function model(array $row)
    {
        $rows = new TermMeta([
            'id'            => $row[0],
            'locale'        => $row[1],
            'term_id'       => $row[2],
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
            'term_metas' => $this,
        ];
    }
}
