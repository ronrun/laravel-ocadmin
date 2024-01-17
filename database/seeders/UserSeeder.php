<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Support\Arr;
use App\Models\User\User;
use App\Models\User\UserMeta;

class UserSeeder extends Seeder
{
    private $faker;
    
    public function __construct()
    {
        $this->faker = Container::getInstance()->make(Generator::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'username' => 'admin',     //帳號
            'name' => 'Administrator', //姓名
            'short_name' => 'ShortName',   //暱稱(顯示名稱)
            'email' => 'admin@example.org',
            'password' => bcrypt('12345678'),
            'mobile' => $this->faker->phoneNumber(),
            'is_active' => 1,
            'is_admin' => 1,
            'email_verified_at' => now(),
            ]);
            
        User::factory()->count(100)->create();

        UserMeta::create([
            'locale' => 'zh_Hant',
            'user_id' => 1,
            'meta_key' => 'is_admin',
            'meta_value' => 1,
            ]);
    }
}
