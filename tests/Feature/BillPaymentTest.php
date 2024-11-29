<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Faker\Factory;
use Tests\TestCase;

class BillPaymentTest extends TestCase
{

    public function test_can_create_user() {

        // create a new user
        $response = $this
        ->json('POST', '/api/auth/signup', [
            "name" => "Tobex",
            "email" => "tobex@gmail.com",
            "phone_number" => "08178273632",
            "password"  => "#Encrypt@password#"
        ]);

    // assert the status code is 201 (Created)
      $response->assertStatus(201);

    }


    public function test_user_can_login() {

        // Attempt to login
        $response = $this
        ->json('POST', '/api/auth/login', [
            "email" => "tobex@gmail.com",
            "password"  => "#Encrypt@password#"
        ]);
         // assert the status code is 200 (Successful login) Ok
        $response->assertStatus(200);
    }

    public function test_user_can_get_balance() {

        
         // Attempt to login
        $loginResponse = $this
        ->json('POST', '/api/auth/login', [
            "email" => "tobex@gmail.com",
            "password"  => "#Encrypt@password#"
        ]);

        // GET the auth token after login
        $token = $loginResponse->decodeResponseJson()['access_token'];

        // append token to request to get user balance
        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
        ->json('GET', '/api/wallet/balance');
       
        // assert the status code is 200 (Ok)
        $response->assertStatus(200);
      
    }

    public function test_user_can_fund_wallet() {

          // Attempt to login
        $loginResponse = $this
        ->json('POST', '/api/auth/login', [
            "email" => "tobex@gmail.com",
            "password"  => "#Encrypt@password#"
        ]);

        // GET the auth token after login
        $token = $loginResponse->decodeResponseJson()['access_token'];

         // append token to request to fund wallet
        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
        ->json('POST', '/api/wallet/fund',
    
        // append data to request
        [
            "amount" => 5000,
            "payment_type"  => "card",
            "transaction_type" => "fund_wallet"
            ]
         );


        // assert that the value funded is NGN5,000
        $this->assertEquals($response->decodeResponseJson()['transaction']['amount'], 5000 );
      
    }


    public function test_user_can_purchase_airtime() {

         // Attempt to login
        $loginResponse = $this
        ->json('POST', '/api/auth/login', [
            "email" => "tobex@gmail.com",
            "password"  => "#Encrypt@password#"
        ]);

        // GET the auth token after login
        $token = $loginResponse->decodeResponseJson()['access_token'];

        
        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
        ->json('POST', '/api/purchase/airtime',
    

        [
            "amount" => 900,
            "phone_number"  => "08173635343",
            "network_id" => "glo"
        ]
    );
       
        // assert that the value purchased is NGN900
        $this->assertEquals($response->decodeResponseJson()['transaction']['amount'], 900 );
      
    }



    public function test_user_can_get_transactions() {

         // Attempt to login
        $loginResponse = $this
        ->json('POST', '/api/auth/login', [
            "email" => "tobex@gmail.com",
            "password"  => "#Encrypt@password#"
        ]);

        // GET the auth token after login
        $token = $loginResponse->decodeResponseJson()['access_token'];

        // append token to request to get user balance
        $response = $this->withHeaders(['Authorization' => 'Bearer '.$token])
        ->json('GET', '/api/transactions'
        );
       
        // assert that the status code is 200 (Successful)
        $response->assertStatus(200);
      
    }


}


