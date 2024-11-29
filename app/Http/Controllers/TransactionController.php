<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
 
     
    public function transactions()
    {
        // Retrieve all transactions of the current auhtneticated user
        $tranactions =  Auth::user()->transaction;
    
        // Return a response 200 OK with the retrieved transactions
        return response()->json([
            "transactions" => $tranactions
        ], 200);
      
    }

}
