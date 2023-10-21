<?php

namespace App\Imports;

use App\Models\Catalog\ProductMeta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ProductMetasImport implements ToModel,WithStartRow,ToCollection
{
    /**
     * @param array $row
     *
     * @return Product|null
     */
    public function model(array $row)
    {
        $product = new ProductMeta([
            //設定欄位對應，第一欄對應name欄位，第二欄對應email欄位
            // first column is row[0]
           'product_id'     => $row[2],
           'locale'    => $row[3], 
           'meta_key' => $row[4],
           'meta_value'    => $row[5],
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
