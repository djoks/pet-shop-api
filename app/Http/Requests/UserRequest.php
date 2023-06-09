<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'is_admin' => 'required|boolean',
            'email' => 'required|email',
            'password' => 'required|string|min:12|confirmed',
            'avatar' => 'nullable|string',
            'address' => 'required|string',
            'phone_number' => 'required|string',
            'is_marketing' => 'required|boolean'
        ];
    }
}
