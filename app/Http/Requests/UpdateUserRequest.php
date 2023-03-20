<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            'sectors' => 'required',
            'agree_to_terms' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The "Name" field is required.',
            'sectors.required' => 'At least one "Sector" must be selected.',
            'agree_to_terms.required' => 'You must agree to terms.'
        ];
    }
}
