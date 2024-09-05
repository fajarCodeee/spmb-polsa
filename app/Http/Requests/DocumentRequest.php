<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
            'ktp' => ['mimes:jpeg,png,gif,bmp,tiff,jpg,webp', 'file', 'max:512', 'nullable'],
            'foto' => ['mimes:jpeg,png,gif,bmp,tiff,jpg,webp', 'file', 'max:512', 'nullable'],
            'ijazah' => ['mimes:jpeg,png,gif,bmp,tiff,jpg,webp', 'file', 'max:512', 'nullable'],
            'kartu_keluarga' => ['mimes:jpeg,png,gif,bmp,tiff,jpg,webp', 'file', 'max:512', 'nullable'],
        ];
        
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array
    {
        return [
            'ktp.extensions' => 'KTP harus berupa file jpg atau png',
            'foto.extensions' => 'Foto harus berupa file jpg atau png',
            'ijazah.extensions' => 'Ijazah harus berupa file jpg atau png',
            'transkrip_nilai.extensions' => 'Transkrip nilai harus berupa file jpg atau png',
            'max' => 'Maksimal ukuran file :max KB'
        ];
    }
}
