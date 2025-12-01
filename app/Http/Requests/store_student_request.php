<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class store_student_request extends FormRequest
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
        'student_name' => 'required|string|max:255',
        'student_phone' => 'required|string|max:15',
        'student_university' => 'required|string',
        'student_major' => 'required|string|max:100',
        'student_city' => 'required|string',
        'father_name' => 'required|string|max:255',
        'father_phone' => 'required|string|max:15',
        'skills' => 'required|string'
        ];
    }
}
