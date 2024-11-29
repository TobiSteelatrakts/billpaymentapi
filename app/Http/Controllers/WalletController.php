<?php

namespace App\Http\Controllers;
use App\Rules\Rules\CheckString;
use App\Services\LockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Faker\Generator as Faker;

class WalletController extends Controller
{



    private $lockService;

    public function __construct(LockService $lockService)
    {

        // Dependency injection for LockService
        // The lock service prevents concurrency attacks (e.g. race conditions) since the database cache lock only allows one request from  a user at a time 
        $this->lockService = $lockService;

    }


    public function balance()
    {


        // Retrieve the current authenticated user's wallet balance and return it in a response 200 OK
        $balance = Auth::user()->wallet->balance;

        return response()->json([
            'balance' => $balance,
        ], 200);

    }

    public function fund(Request $request, Faker $faker)
    {

        // Input validation
        $request->validate([
            'amount' => 'required|integer|min:1',
            'payment_type' => ['required', 'string', new CheckString(['card', 'wallet'])], // check that the payment type is either 'card' or 'wallet
            'transaction_type' => ['required', 'string', new CheckString(['fund_wallet', 'airtime_purchase'])], // check that the transaction type type is either 'airtime_purchase' or 'fund_wallet
        ]);

        // Use the lock service to fund the wallet and also prevent concurrency attacks
        $response = $this->lockService->fundWalletLock($request, $faker);

        // Return the response (Response from lock service is already JSON)
        return $response;



    }


}
