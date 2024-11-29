<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Faker\Generator as Faker;

class TransactionController extends Controller
{
 
     
    public function transactions()
    {
        // Retrieve all transactions of the current validated user
        $tranactions =  Auth::user()->transaction;
    
        // Return a response 200 OK with the retrieved transactions
        return response()->json([
            "transactions" => $tranactions
        ], 200);
      
    }

}
