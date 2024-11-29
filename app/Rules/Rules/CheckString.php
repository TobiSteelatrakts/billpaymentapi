<?php

namespace App\Rules\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckString implements ValidationRule
{

    private $stringArray;

    public function __construct($stringArray)
    {

        
        $this->stringArray = $stringArray;

    }


    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
     

          // validate that the value (from the request) is in the array from the constructor above.
        if (!in_array( strtolower($value), $this->stringArray)) {

             // custom error message when the value is not in the array from the constructor above.
            $fail('The '.$attribute.' should be one of these: '.implode(",", $this->stringArray));
        }
    }
}
