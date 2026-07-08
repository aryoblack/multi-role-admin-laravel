<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
            'role_id' => ['required', $this->roleRule()],
            'phone' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    private function roleRule()
    {
        $rule = Rule::exists('roles', 'id');

        if (!$this->user()?->isSuperAdmin()) {
            $rule->where(fn ($query) => $query->where('nama_role', '!=', User::SUPER_ADMIN_ROLE));
        }

        return $rule;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama lengkap',
            'email' => 'alamat email',
            'password' => 'kata sandi',
            'role_id' => 'role',
            'phone' => 'nomor telepon',
            'status' => 'status',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'Email ini sudah digunakan oleh user lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role_id.exists' => 'Role yang dipilih tidak valid.',
        ];
    }
}
