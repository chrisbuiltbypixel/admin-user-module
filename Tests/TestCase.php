<?php

namespace Modules\AdminUser\Tests;

use Tests\CreatesApplication;
use Modules\AdminUser\Entities\AdminUser;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * set up a user and select a mosque account
     */
    public function actAsUser()
    {
        $user = User::factory()->create();

        // log in the user
        return Passport::actingAs(
            $user,
            [],
            'user_api'
        );
    }

    public function actAsAdminUser()
    {
        $user = AdminUser::factory()->create([
            'password' => 'password',
        ]);

        // log in the user
        return Passport::actingAs(
            $user,
            [],
            'admin_api'
        );
    }
}
