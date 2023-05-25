<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class PasswordOldRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
     //   dd($value);
        $oldpass = auth()->guard('admin')->user()->password;
        if (!Hash::check($value, $oldpass)) {
            $fail('The :attribute doesnt match.');
        }
       // dd($oldpass);
    }
}
