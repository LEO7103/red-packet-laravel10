<?php

namespace App\Http\Controllers;

use App\Services\BuyerService;

class TestBuyerTransactionController extends Controller
{
    protected $buyerService;

    public function __construct(BuyerService $buyerService)
    {
        $this->buyerService = $buyerService;
    }

    public function success()
    {
        $this->buyerService->addPointsSuccessfully(1, 10);
        return 'Buyer 加分成功!';
    }

    public function fail()
    {
        try {
            $this->buyerService->addPointsAndFail(1, 10);
        } catch (\Exception $e) {
            return 'Buyer 加分失敗，已回滾!';
        }
    }

    public function failtest()
    {
        try {
            $this->buyerService->addPointsAndFail(1, 10);
        } catch (\Exception $e) {
            return 'Buyer 加分失敗，已回滾!';
        }
    }
}
