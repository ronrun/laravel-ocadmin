<?php

namespace App\Imports;

use App\Models\Catalog\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ProductsImport implements ToModel,WithStartRow,ToCollection
{
    public function model(array $row)
    {
        $product = new Product([
            'id'     => $row[1],
            'model'     => $row[2],
            'is_active'     => $row[3],
        ]);

        return $product;
    }

    public function startRow(): int
    {
        return 3;
    }


    public function collection(Collection $rows)
    {}
}
