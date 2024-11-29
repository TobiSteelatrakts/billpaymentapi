<?php

namespace App\Rules\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StringLength implements ValidationRule
{


    private $length;

    public function __construct($length)
    {

        $this->length = $length;

    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

         // validate that the length of the string is equal to the provided length in the constructor above
      
        if ((strlen($value) > $this->length)) {

            // custom error message when the length of the string does not match the provided length.
            
            $fail('The '.$attribute. ' field must be atmost '.$this->length . ' characters long.');
        }
    }
}
