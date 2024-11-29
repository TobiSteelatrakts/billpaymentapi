<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Rules\Rules\NumberLength;
use App\Rules\Rules\StringLength;
use Hash;
use Illuminate\Http\Request;
use Faker\Generator as Faker;
use Laravel\Passport\Token;
class AuthController extends Controller
{


    public function signup(Request $request, Faker $faker)
    {


        // Input validation
        $request->validate([
            'name' => ['required', 'string', new StringLength(10)], // custom input validation to check name length
            'email' => 'required|string|unique:users',
            'phone_number' => ['required', 'string', 'unique:users', new NumberLength(11)],
            'password' => 'required|string',

        ]);


        // Create a new user and wallet, save to the database
        $user = new User([
            'id' => $faker->unique()->uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password)
        ]);
        $user->save();


       
         // Create a wallet for the user
         // Optional to add the balance field becuase it is default to 0 in the db migration when you create a new user
         

        $wallet = new Wallet([
            'id' => $faker->unique()->uuid(),
            'user_id' => $user->id
        ]);
        $wallet->save();

        // Return a response 201 created successfully to the user;
        return response()->json([
            'success' => 'Account created successfully, proceed to login',
        ], 201);



    }



    public function login(Request $request)
    {


        // Input validation
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',

        ]);


        // Attempt to get the user with the validated email 
        $user = User::where('email', $request->email)->firstOrFail();


        // Check if the password matches the hashed user's password in the database
        if (!(Hash::check($request->password, $user->password))) {

            return response()->json(['message' => 'Invalid credentials'], 400);
        }


        // If the credentials are correct, delete any existing tokens for this user before  creatringing a new one
        // This helps prevent concurrency attacks (e.g. race conditions) since  a user can't be logged in twice at the same time
        if (count(Token::where('user_id', $user->id)->get()) > 0) {

            Token::where('user_id', $user->id)->delete();
        }


        // Generate a new token for the user and return it
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }



}
