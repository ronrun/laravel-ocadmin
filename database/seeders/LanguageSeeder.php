<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Sysdata\Language;
use Flynsarmy\CsvSeeder\CsvSeeder;

class LanguageSeeder extends CsvSeeder
{
    public function run()
    {
        DB::connection('sysdata')->table('languages')->truncate();

        // CSV
        $filename = base_path('database/imports/languages.csv');
        $csvData = array_map('str_getcsv', file($filename));

        // 删除開頭的 BOM
        $csvData[0][0] = ltrim($csvData[0][0], "\xEF\xBB\xBF");

        $header = array_shift($csvData);

        foreach ($csvData as $row) {
            $data = array_combine($header, $row);
            DB::connection('sysdata')->table('languages')->insert($data);
        }
        // End CSV
    }
}
