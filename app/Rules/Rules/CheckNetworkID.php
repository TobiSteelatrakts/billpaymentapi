<?php

namespace App\Rules\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckNetworkID implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       
        $networks = ['mtn', 'airtel', 'glo', '9mobile'];


         // validate that the value (network ID in the request) is in this array above
        if (!in_array( strtolower($value), $networks)) {

            // custom error message when the value is not in the array above.
            $fail('The network ID is invalid. Use '.implode(",", $networks));
        }
    }
}
