<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
 BILL PAYMENT API 
</p>

## .
## Prerequisites
- Please Install VSCode on your device

- Install PHP, composer and Laravel installer on your device (If you dont have them installed, open terminal and run this command below)
- Run this command if you are on a Mac ("Please don't add the first dash dash sign , applies to all the other commands below")  -  /bin/bash -c "$(curl -fsSL https://php.new/install/mac/8.3)"

- Run this command if you are on Windows(make sure to run it as administrator) -  

Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.3'))

- Install Mamp server on your device for Mac OS or Wamp server  for Windows
- Install Postman on your device
- Please make sure you are running atleast PHP 8.2 on your device



## .
## How to setup the Bill payment API on your device

Please follow the steps below to setup the Bill payment application on your device

-  Open VSCode  then open terminal and paste this code to Clone the repo -   git clone https://github.com/TobiSteelatrakts/billpaymentapi.git

- Or simply download it here https://github.com/TobiSteelatrakts/billpaymentapi.git (click on code and find the download button), unzip it after downloading

- CD into the folder inside VSCode (make sure you are inside the folder that was newly cloned/ downloaded)

- Type  composer install in the terminal (This would install all the required dependencies)
- After composer is done,  look for a file called env.example in the cloned/downloaded folder, rename it to env.
- Start your Wamp / Mamp server
- Go back to VSCode terminal and run this command (Just press enter if it ask any question)  -     php artisan migrate
- Next run this command (press enter if for any question asked)  -     php artisan passport:client --personal 
- Next start your server at port 8000 by running this command in the terminal as well - php artisan serve ;

- You can now start testing the api

- Open Postman and import the api-docs.json collection (find it inside this same project folder that you cloned/downloaded)



## .
## Testing the API in Postman

Each api endpoint has a sample request, a success request and a failed request
 
- After importing the api-docs.json collection you can test the following endpoints

- User Create (Create User): http://127.0.0.1:8000/api/auth/create         POST request    - (Creates a new user and  a wallet instantly )
- User Login: http://127.0.0.1:8000/api/auth/login        POST request   -  (After successful login, make sure to use the access_token generated for the remaining requests below) just add Authorization:  Bearer + access_token in the request headers in Postman
- Wallet Balance :     http://127.0.0.1:8000/api/wallet/balance         GET request
- Funt Wallet :      http://127.0.0.1:8000/api/wallet/fund         POST request
- Purchase Airtime (Purchase) :      http://127.0.0.1:8000/api/purchase/airtime         POST request
- Transactions : http://127.0.0.1:8000/api/transactions           GET request




## .
## API UNIT TESTING / PEST TESTING

I used the feature test since it is more robust

- Go to tests folder, click on feature you will find the test called BillPaymentTest

- Eg. To test if user sign up - open terminal in the project folder and run this command  -   php artisan test --filter test_can_create_user           (you should see a success message test passed)

- To test if user can login - run this command -   php artisan test --filter test_user_can_login

- To test if user can get balance run this command -   php artisan test --filter test_user_can_get_balance

- To test if user can fund wallet run this command -   php artisan test --filter test_user_can_fund_wallet

- To test if user can purchase airtime run this command -   php artisan test --filter test_user_can_purchase_airtime

- To test if user can get transactiions run this command -   php artisan test --filter test_user_can_get_transactions

## .
## FEATURES IMPLEMENTED

- Validation: Implemented 4 additional custom validation to validate other user input eg. NumberLegth , CheckNetworkID etc , they are located inside Rules folder in the project

- Prevent concurrency attacks (e.g. race conditions) - I used the Laravel built in lock to prevent concurrency attack also I implemented token revote which ensures that a user can only be logged in on one device at a time this is also another way to prevent concurrency attack when purchasing airtime


- Lock Service -  Created a lock service to prevent concurrency attack which we can inject as a dependency into other controllers, that way it keeps the code dry and reduces repetition


- Eloquent Relationship - Allows for the creation of  relationship between User and wallet and user and transactions. Inside models folder we have the models and their relationship

- Authentication - Used laravel passport to authenticate users and ensure that users have acccess to their own resource only when authenticated

- Unit/ Pest testing - Carried out different test to ensure that the application works as expected , the tests are already described above


## .
## SECURITY

- Used Gitignore to prevent pushing sensitive information to Github such as .env file
- Disabled APP_DEBUG flag in .env to prevent leaking sensitive information in production environment
- Passowrd hashing to ensure all passwords are not readable as plain text
- Validation checks to ensure a strong password is created by the user using some built in Laravel validation such as
min(), letters(), mixedCase(), symbols(), uncompromised() 

- I used laravel hitten attribute in user modal to hide Password in response
- Used UUID for ID field in the database to enure that IDs are uniqure and also not prone to collisions
- Used and created custom validation rules to better validate user inputs
- Implemented a lock service to concurrency attacks



