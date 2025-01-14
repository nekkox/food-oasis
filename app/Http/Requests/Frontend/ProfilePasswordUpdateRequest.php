<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePasswordUpdateRequest extends FormRequest
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
            'current_password' => ['required', 'string', 'max:50', 'current_password'],
            'password' => ['required', 'string','min:5', 'max:50','confirmed'],
            'password_confirmation'=>['required', 'string','min:5', 'max:50'],
        ];
    }

    //Custom messages for validation errors
    public function messages(): array{
        return [
            'current_password.current_password' => 'Current Password is invalid',
        ];
    }
}
