<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buyer;

class BuyerSeeder extends Seeder
{
    public function run()
    {
        Buyer::create([
            'id' => 1,
            'name' => '測試買家',
            'points' => 0,
        ]);
    }
}
