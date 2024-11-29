<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;

use Illuminate\Support\Facades\Route;


// authorization route
Route::prefix('auth')->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('create', [AuthController::class, 'create']);
    
});


// wallet routes protected with the auth:api middleware
Route::prefix('wallet')->middleware(["auth:api"])->group(function () {
    Route::get('balance', [WalletController::class, 'balance']);
    Route::post('fund', [WalletController::class, 'fund']);
});


// user route protected with the auth:api middleware
Route::prefix('purchase')->middleware(["auth:api"])->group(function () {

    Route::post('airtime', [UserController::class,  'airtime']);

});


// transaction route protected with the auth:api middleware
Route::middleware(["auth:api"])->group(function () {

    Route::get('transactions', [TransactionController::class,  'transactions']);

});

