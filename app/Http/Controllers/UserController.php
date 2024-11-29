<?php

namespace App\Http\Controllers;
use App\Rules\Rules\CheckNetworkID;
use App\Rules\Rules\NumberLength;
use App\Services\LockService;
use Illuminate\Http\Request;

use Faker\Generator as Faker;



class UserController extends Controller
{


    private $lockService;

    public function __construct(LockService $lockService)
    {
        // Dependency injection for LockService
        // The lock service prevents concurrency attacks (e.g. race conditions) since the database cache lock only allows one request from  a user at a time 
        $this->lockService = $lockService;

    }


    public function airtime(Request $request, Faker $faker)
    {

        // Input validation
        $request->validate([
            'amount' => 'required|integer|min:1',
            'phone_number' => ['required', 'string', new NumberLength(11)], // validate that the phone number is a valid 11 digit number
            'network_id' => ['required', 'string', new CheckNetworkID] // check that the network id is string and  it is either mtn, glo, airtel or 9mobile
        ]);

        // Use the lock service to purchase airtime and also prevent concurrency attacks
        $response = $this->lockService->purchaseAirtimeLock($request, $faker);

        // Return the response (Response from lock service  is  already JSON)
        return $response;

    }


}
