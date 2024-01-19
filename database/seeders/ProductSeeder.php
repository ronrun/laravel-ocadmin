<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalog\Product;
use App\Models\Catalog\ProductMeta;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'id' => 1,
            'model' => 'apple',
            'slug' => 'apple',
            'is_active' => 1,
        ]);

        ProductMeta::create([
            'locale' => 'en',
            'product_id' => 1,
            'meta_key' => 'name',
            'meta_value' => 'Apple',
        ]);

        ProductMeta::create([
            'locale' => 'zh_Hant',
            'product_id' => 1,
            'meta_key' => 'name',
            'meta_value' => '蘋果',
        ]);
        Product::create([
            'id' => 2,
            'model' => 'orange',
            'slug' => 'orange',
            'is_active' => 1,
        ]);

        ProductMeta::create([
            'locale' => 'en',
            'product_id' => 2,
            'meta_key' => 'name',
            'meta_value' => 'Orange',
        ]);

        ProductMeta::create([
            'locale' => 'zh_Hant',
            'product_id' => 2,
            'meta_key' => 'name',
            'meta_value' => '柳丁',
        ]);
    }
}
