<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class store_payment_request extends FormRequest
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
            'student_name' => 'required|string',
            'food_payment' => 'required | int',
            'housing_payment' => 'required | int',
            'payment_month' => 'required|in:January,February,March,April,May,June,July,August,September,October,November,December'
        ];
    }
}
