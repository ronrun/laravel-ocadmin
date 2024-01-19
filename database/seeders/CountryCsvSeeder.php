<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Sysdata\Country;
use Flynsarmy\CsvSeeder\CsvSeeder;

class CountryCsvSeeder extends CsvSeeder
{
    public function run()
    {
        // 在数据导入前切换到指定的数据库连接
        DB::connection('sysdata')->table('countries')->truncate();

        // 导入数据
        $filename = base_path('database/imports/countries.csv');
        $csvData = array_map('str_getcsv', file($filename));

        // 删除開頭的 BOM
        $csvData[0][0] = ltrim($csvData[0][0], "\xEF\xBB\xBF");

        $header = array_shift($csvData);

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);
            DB::connection('sysdata')->table('countries')->insert($data);
        }
    }
}
