<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brosur' => ['mimes:jpeg,png,gif,bmp,tiff,jpg,webp', 'file', 'nullable'],
            'rincian_biaya' => ['mimes:jpeg,png,gif,bmp,tiff,jpg,webp', 'file', 'nullable'],
        ];
    }
}
