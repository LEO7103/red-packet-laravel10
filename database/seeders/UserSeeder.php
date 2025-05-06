<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buyer;

class UserSeeder extends Seeder
{
    public function run()
    {
        Buyer::create([
            'id' => 1, // 手動指定 ID = 1
            'name' => '測試用戶',
            'points' => 0,
        ]);
    }
}