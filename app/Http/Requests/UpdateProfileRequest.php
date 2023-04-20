<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'titre'          => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'telephone'      => 'nullable|string|max:255',
            'link_linkedin'  => 'nullable|url|max:255',
            'link_github'    => 'nullable|url|max:255',
            'bio'            => 'nullable|string|max:255',
        ];
    }
}
