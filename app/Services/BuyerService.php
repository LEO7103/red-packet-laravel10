<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Buyer;
use Exception;

class BuyerService
{
    public function addPointsAndFail($buyerId, $points)
    {
        DB::transaction(function () use ($buyerId, $points) {
            $buyer = Buyer::findOrFail($buyerId);
            $buyer->points += $points;
            $buyer->save();

            throw new Exception('Something went wrong!');
        });
    }

    public function addPointsSuccessfully($buyerId, $points)
    {
        DB::transaction(function () use ($buyerId, $points) {
            $buyer = Buyer::findOrFail($buyerId);
            $buyer->points += $points;
            $buyer->save();
        });
    }
}
