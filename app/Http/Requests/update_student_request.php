<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class update_student_request extends FormRequest
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
        'student_name' => 'sometimes|string|max:255',
        'student_phone' => 'sometimes|string|max:15',
        'student_university' => 'sometimes|string',
        'student_major' => 'sometimes|string|max:100',
        'student_city' => 'sometimes|string',
        'father_name' => 'sometimes|string|max:255',
        'father_phone' => 'sometimes|string|max:15',
        'skills' => 'sometimes|string'
        ];
    }
}
