<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class check_login_request extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_email' => 'required|email|exists:app_users,user_email',
            'user_password' => 'required|string|min:5'
        ];
    }
}
