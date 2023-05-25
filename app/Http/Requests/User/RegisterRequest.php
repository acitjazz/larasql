<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'country' => 'required',
            'phone' => 'required',
            'phone_code' => 'required',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'roles' => 'required',
            'pic' => 'required',
            'company' => 'required'
            // 'captcha_token' => ['required', new Recaptcha]
        ];
    }
    public function messages()
    {
        return [
            'name.required'  => 'name required',
        ];
    }
}
