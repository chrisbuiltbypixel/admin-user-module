<?php

namespace Modules\AdminUser\Tests\Feature\Nucleus;

use Modules\AdminUser\Tests\TestCase;
use Modules\AdminUser\Entities\AdminUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->actAsAdminUser();
        $this->withoutExceptionHandling();
    }

    public function test_we_can_get_the_current_logged_in_user()
    {
        $response = $this->get('api/auth/current');

        $response->assertStatus(200);
    }

    public function test_we_get_can_a_list_of_admin_users()
    {
        $response = $this->get('api/admin-users');

        $response->assertStatus(200);

    }

    public function test_we_can_get_a_single_admin_user()
    {
        $user = AdminUser::factory()->create();

        $response = $this->get("api/admin-users/$user->id");

        $response->assertStatus(200);

    }

    public function test_we_can_create_an_admin_user()
    {
        $user = AdminUser::factory()->make()->makeVisible('password')->toArray();

        // post to the endpoint
        $response = $this->post('api/admin-users', $user);

        // assert response
        $response->assertStatus(201);

    }

    public function test_we_can_edit_an_admin_user()
    {
        $user = AdminUser::factory()->create([
            'first_name' => "Old First Name",
            'last_name' => "Old Last Name",
            'email' => "old@example.org",
        ]);

        $data = [
            'first_name' => "New First Name",
            'last_name' => "New Last Name",
            'email' => 'new@example.org',
            'password' => 'updated',
            'password_confirmation' => 'updated',
        ];

        $response = $this->put("api/admin-users/$user->id", $data);

        $response->assertStatus(200);

        $user->refresh();

        $this->assertEquals($data['first_name'], $user->first_name);
        $this->assertEquals($data['last_name'], $user->last_name);
        $this->assertEquals($data['email'], $user->email);

    }

    public function test_we_can_update_a_logged_in_users_password()
    {
        $data = [
            'old_password' => "password",
            'new_password' => "NewPassword",
        ];

        $user = Auth::guard('admin_api')->user();

        $response = $this->put("api/auth/current/update-password", $data);

        $response->assertStatus(200);

    }

    public function test_we_can_delete_an_admin_user()
    {
        $user = AdminUser::factory()->create()->id;

        $data = [
            'id' => [$user],
        ];

        $response = $this->delete("api/admin-users", $data);

        $response->assertStatus(200);
    }

}
