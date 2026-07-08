<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
    }

    /** @test */
    public function it_can_create_a_user()
    {
        // Create a role first
        $role = Role::factory()->create(['nama_role' => 'Test Role']);

        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'role_id' => $role->id,
            'phone' => '081234567890',
            'status' => 'active',
        ];

        // Act as an authenticated user
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $user = $this->userService->createUser($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $role = Role::factory()->create();
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        $admin = User::factory()->create();
        $this->actingAs($admin);

        $updateData = [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'role_id' => $role->id,
            'status' => 'active',
        ];

        $updatedUser = $this->userService->updateUser($user, $updateData);

        $this->assertEquals('New Name', $updatedUser->name);
        $this->assertEquals('new@example.com', $updatedUser->email);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $result = $this->userService->deleteUser($user);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    /** @test */
    public function it_can_get_active_users_count()
    {
        User::factory()->count(5)->create(['status' => 'active']);
        User::factory()->count(3)->create(['status' => 'inactive']);

        $count = $this->userService->getActiveUsersCount();

        $this->assertEquals(5, $count);
    }

    /** @test */
    public function it_can_get_users_by_role()
    {
        $role = Role::factory()->create();
        User::factory()->count(3)->create(['role_id' => $role->id]);
        User::factory()->count(2)->create(); // Different role

        $users = $this->userService->getUsersByRole($role->id);

        $this->assertCount(3, $users);
    }
}
