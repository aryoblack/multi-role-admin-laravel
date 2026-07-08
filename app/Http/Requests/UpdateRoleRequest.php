<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $nameRules = ['required', 'string', 'max:255', 'unique:roles,nama_role,' . $this->role->id];

        if (!$this->user()?->isSuperAdmin()) {
            $nameRules[] = Rule::notIn([User::SUPER_ADMIN_ROLE]);
        }

        return [
            'nama_role' => $nameRules,
        ];
    }

    public function messages(): array
    {
        return [
            'nama_role.required' => 'Nama role wajib diisi',
            'nama_role.unique' => 'Nama role sudah digunakan',
        ];
    }
}
