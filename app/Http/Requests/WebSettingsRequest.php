<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->check() && auth()->user()->hasAnyRole(['admin', 'superadmin'])) {
            return true;
        }

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
            'name' => ['nullable', 'string'],
            'title_home' => ['nullable', 'string'],
            'title_dashboard' => ['nullable', 'string'],
            'institution_short_name' => ['nullable', 'string'],
            'institution_synopsis' => ['nullable', 'string'],
            'institution_vision_mission' => ['nullable', 'string'],
            'institution_history' => ['nullable', 'string'],
            'title_exam' => ['nullable', 'string'],
            'footer' => ['nullable', 'string'],
            'payment_bank' => ['nullable', 'string'],
            'payment_account' => ['nullable', 'string'],
            'payment_name' => ['nullable', 'string'],
            'contact_telp' => ['nullable', 'string'],
            'contact_email' => ['nullable', 'string'],
            'contact_fax' => ['nullable', 'string'],
            'contact_address' => ['nullable', 'string'],
            'contact_maps' => ['nullable', 'string'],
            'contact_facebook' => ['nullable', 'string'],
            'contact_whatsapp' => ['nullable', 'string'],
            'contact_instagram' => ['nullable', 'string'],
            'contact_twitter' => ['nullable', 'string'],
            'contact_youtube' => ['nullable', 'string'],
            'link_univ' => ['nullable', 'string'],
            'path_brosur' => ['nullable', 'image', 'extensions:jpeg,png,jpg,gif,svg', 'max:5000'],
            'path_rincian_harga' => ['nullable', 'image', 'extensions:jpeg,png,jpg,gif,svg', 'max:5000'],
        ];
    }
}
