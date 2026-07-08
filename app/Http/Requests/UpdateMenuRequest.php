<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_menu' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'urutan' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_menu.required' => 'Nama menu wajib diisi',
            'url.required' => 'URL wajib diisi',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'parent_id.exists' => 'Parent menu tidak valid',
        ];
    }
}
