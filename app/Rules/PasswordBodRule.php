<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordBodRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $bod = Carbon::parse(request('bod') ?? now())->format('dmY');
        $password = request('password');
        $email = request('email');
        $name = request('name');
        if (preg_match("#(($email)|($bod)|($name))#i", $password)) {
            $fail('The :attribute must be not contain your name email or birthdate.');
        }
    }
}
