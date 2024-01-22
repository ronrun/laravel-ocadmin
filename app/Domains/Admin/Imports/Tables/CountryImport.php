<?php

namespace App\Domains\Admin\Imports\Tables;

use App\Models\Sysdata\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class CountryImport implements ToModel,WithStartRow,ToCollection
{
    public function model(array $row)
    {
        $rows = new Country([
            'id'            => $row[0],
            'code'          => $row[1],
            'name'          => $row[2],
            'native_name'   => $row[3],
            'iso_code_3'    => $row[4],
            'postal_code_required' => $row[5],
            'is_active'     => $row[6],
        ]);

        return $rows;
    }

    public function startRow(): int
    {
        return 2;
    }


    public function collection(Collection $rows)
    {}
}
