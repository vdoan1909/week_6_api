<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bio' => 'nullable',
            'date_of_birth' => 'nullable|date',
            'avatar' => 'nullable|mimes:png,jpg,jpeg,webp',
        ];
    }
}
