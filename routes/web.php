


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestBuyerTransactionController;

Route::get('/', function () {
    return view('welcome');
});

// ★ 這是重點！加上這兩行
Route::get('/buyer-transaction-success', [TestBuyerTransactionController::class, 'success']);
Route::get('/buyer-transaction-fail', [TestBuyerTransactionController::class, 'fail']);
