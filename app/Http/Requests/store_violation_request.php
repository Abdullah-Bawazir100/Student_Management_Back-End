<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class store_violation_request extends FormRequest
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
            'student_id' => 'required|exists:Students,id',
            'student_name' => 'required|string|exists:Students,student_name',
            'title' => 'required|string',
            'discipline' => 'required|string'
        ];
    }
}
