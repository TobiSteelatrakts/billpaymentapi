<?php
namespace App\Services;
use App\Models\Transaction;
use Auth;
use Cache;

use Illuminate\Http\Request;
use Faker\Generator as Faker;

class LockService
{


    public function purchaseAirtimeLock(Request $request, Faker $faker)
    {


        // try catch all exceptions
        // Input validation has already been done in the controller
        try {

            // create lock to prevent  concurrency attacks (e.g. race conditions) by only releasing the lock after the 
            // process has completed
            $lock = Cache::lock('purchase-airtime-lock', 5);


            // if the lock could not be acquired within 5 seconds, throw an exception
            if ($lock->block(2)) {

                // if the lock is acquired  now purchase airtime 
                $user = Auth::user();
                $balance = $user->wallet->balance;


                $payment_type = 'wallet'; // hardcoded for simpliciticy (in production we would create a table to manage this)
                $transaction_type = 'airtime_purchase'; // hardcoded for simpliciticy as well


                // check if the user has enough balance to make the purchase
                if ($balance < $request->amount) {

                    return response()->json([

                        "message" => "Insufficient balance, please fund your wallet",

                    ], 400);
                }

                // deduct the amount from the user's balance
                $user->wallet->balance = ($balance - $request->amount);
                $user->wallet->save();

                // create a transaction record
                $transaction = new Transaction([
                    'id' => $faker->unique()->uuid(),
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                    'phone_number' => $request->phone_number,
                    'payment_type' => $payment_type,
                    'transaction_type' => $transaction_type,
                    'network_id' => $request->network_id
                ]);
                $transaction->save();

                // return response containing the airtime transaction
                return response()->json([
                    "success" => "Purchase completed successfully",
                    'transaction' => $transaction,
                ], 200);


            }
        } catch (\Throwable $th) {

            // if the lock could not be acquired within 5 seconds, return an error response
            return response()->json([
                "message" => "Unable to process transaction at the moment, please try again later",
            ], 400);
        }


    }




    public function fundWalletLock(Request $request, Faker $faker)
    {


        // try catch all exceptions
        // Input validation has already been done in the controller
        try {

            // create lock to prevent  concurrency attacks (e.g. race conditions) by only releasing the lock after the
            $lock = Cache::lock('fund-wallet-lock', 5);

            if ($lock->block(2)) {

                // if the lock is acquired  now fund the wallet
                $user = Auth::user();
                $balance = $user->wallet->balance;
                $user->wallet->balance = ($balance + $request->amount);
                $user->wallet->save();


                // create a transaction record
                $transaction = new Transaction([
                    'id' => $faker->unique()->uuid(),
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                    'payment_type' => $request->payment_type,
                    'transaction_type' => $request->transaction_type
                ]);
                $transaction->save();

                // return response containing the updated balance
                return response()->json([
                    "success" => "Wallet funded successfully",
                    'balance' => $user->wallet->balance,
                    'transaction' => $transaction,
                ], 200);


            }
        } catch (\Throwable $th) {

            // if the lock could not be acquired within 5 seconds, return an error response
            return response()->json([
                "message" => "Unable to process transaction at the moment, please try again later",
            ], 400);
        }


    }


}