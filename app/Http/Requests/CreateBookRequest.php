<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' =>'required|string|min:3|max:100',
            'author' =>'required|string|min:3|max:100',
            'description' =>'required|string|min:10|max:1000',
            'cover_image' =>'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
