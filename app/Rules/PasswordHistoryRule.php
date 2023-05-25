<?php

namespace App\Rules;

use App\Models\AdminPassword;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class PasswordHistoryRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $id = auth()->guard('admin')->user()->id;
        $passes = AdminPassword::where('admin_id',$id)->latest('created_at')->limit(3)->pluck('password');
        foreach ($passes as $key => $oldpass) {
            if (Hash::check($value, $oldpass)) {
                $fail('Your password has been used before, please use another password.');
            }
        }
    }
}
