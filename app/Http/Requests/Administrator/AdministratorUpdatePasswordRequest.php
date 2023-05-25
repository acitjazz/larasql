<?php

namespace App\Http\Requests\Administrator;

use App\Models\Admin;
use App\Rules\PasswordBodRule;
use App\Rules\PasswordHistoryRule;
use App\Rules\PasswordOldRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdministratorUpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => ['required',new PasswordOldRule],
            'password' => ['required', 'required_with:repassword','same:repassword',
                            Password::min(8)->letters()->mixedCase()->numbers()->symbols(),
                            new PasswordBodRule,new PasswordHistoryRule],
            'repassword' => ['required',Password::min(8)->letters()->mixedCase()->numbers()->symbols()],

        ];
    }
}
