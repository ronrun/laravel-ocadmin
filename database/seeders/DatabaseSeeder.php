<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Laravel 官網慣例使用單數+Seeder，例如 UserSeeder
     */
    

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,    
            //CountriesCsvSeeder::class,
            CountryXlsxSeeder::class,
            PermissionXlsxSeeder::class,
                  
            ProductSeeder::class,           
        ]);
    }
}
