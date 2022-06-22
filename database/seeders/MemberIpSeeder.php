<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberIpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("TRUNCATE TABLE `member_ips`");
        for ($i=1; $i < 10000; $i++) {
            $member_id = mt_rand(1, 200);
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
