<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            MemberSeeder::class,
        ]);

        DB::statement("TRUNCATE TABLE `member_ips`");
        for ($i=1; $i < 10000; $i++) {
            $member_id = mt_rand(1, 500);
            $ip = mt_rand(0, 255) . "." . mt_rand(0, 255) . "." . mt_rand(0, 255) . "." . mt_rand(0, 255);
            DB::table('member_ips')->insert([
                'ip' => $ip,
                'member_id' => $member_id,
                'status' => 1,
            ]);
            DB::table('members')->where('id', $member_id)->update([
                'ip' => $ip,
            ]);
        }
    }
}
