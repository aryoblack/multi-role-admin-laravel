<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    /**
     * Create a new user
     */
    public function createUser(array $data): User
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $data['role_id'],
                'phone' => $data['phone'] ?? null,
                'status' => $data['status'] ?? 'active',
            ]);

            Log::info('User created', [
                'created_by' => auth()->id(),
                'user_id' => $user->id,
                'user_email' => $user->email,
            ]);

            return $user;
        } catch (\Exception $e) {
            Log::error('User creation failed', [
                'created_by' => auth()->id(),
                'error' => $e->getMessage(),
                'email' => $data['email'] ?? null,
                'role_id' => $data['role_id'] ?? null,
                'status' => $data['status'] ?? null,
            ]);
            throw $e;
        }
    }

    /**
     * Update an existing user
     */
    public function updateUser(User $user, array $data): User
    {
        try {
            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'phone' => $data['phone'] ?? null,
                'status' => $data['status'] ?? 'active',
            ];

            // Only update password if provided
            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            Log::info('User updated', [
                'updated_by' => auth()->id(),
                'user_id' => $user->id,
                'changes' => $this->redactSensitiveFields($updateData),
            ]);

            return $user->fresh();
        } catch (\Exception $e) {
            Log::error('User update failed', [
                'updated_by' => auth()->id(),
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Delete a user
     */
    public function deleteUser(User $user): bool
    {
        try {
            $userId = $user->id;
            $userEmail = $user->email;

            $user->delete();

            Log::info('User deleted', [
                'deleted_by' => auth()->id(),
                'user_id' => $userId,
                'user_email' => $userEmail,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('User deletion failed', [
                'deleted_by' => auth()->id(),
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Get user with role
     */
    public function getUserWithRole(int $userId): ?User
    {
        return User::with('role')->find($userId);
    }

    /**
     * Get all users with roles
     */
    public function getAllUsersWithRoles()
    {
        return User::with('role')->get();
    }

    /**
     * Get active users count
     */
    public function getActiveUsersCount(): int
    {
        return User::where('status', 'active')->count();
    }

    /**
     * Get users by role
     */
    public function getUsersByRole(int $roleId)
    {
        return User::where('role_id', $roleId)->with('role')->get();
    }

    private function redactSensitiveFields(array $data): array
    {
        unset($data['password']);

        return $data;
    }
}
