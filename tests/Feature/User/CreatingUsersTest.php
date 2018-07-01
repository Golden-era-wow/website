<?php

namespace Tests\Feature\User;

use App\Emulators\SkyFire;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatingUsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function itCreatesAUserAndAGameAccountUponRegistration()
    {
        $accountName = $this->faker()->firstName;
        $email = $this->faker()->email;

        $this->postJson(
            '/register',
            [
                'account_name' => $accountName,
                'name' => 'John Doe',
                'email' => $email,
                'password' => 'secret',
                'password_confirmation' => 'secret'
            ]
        )->assertRedirect('/home');

        $this->assertDatabaseHas('users', [
            'account_name' => $accountName,
            'name' => 'John Doe',
            'email' => $email
        ]);

        $this->assertDatabaseHas('account', [
            'username' => $accountName,
            'email' => $email
        ], 'skyfire_auth');

        $user = User::where('email', $email)->with('gameAccounts')->first();
        $this->assertNotNull($user->gameAccounts->first()->account_id);

        // Clean up the newly created account on the skyfire_auth database.
        (new SkyFire)->deleteAccount($user);
    }

    /**
     * @test
     */
    public function accountNameCannotBeLongerThan16Letters()
    {
        $this->json('POST', '/register', [
            'account_name' => 'jessieIsASexyDevil',
            'name' => 'Jessie Doe',
            'email' => 'jessie@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ])->assertJsonValidationErrors('account_name');

        $this->assertDatabaseMissing('users', [
            'account_name' => 'jessieIsASexyDevil',
            'name' => 'Jessie Doe',
            'email' => 'jessie@example.com'
        ]);
    }

    /**
     * @test
     */
    public function accountNameCannotContainNumbers()
    {
        $this->json('POST', '/register', [
            'account_name' => 'jessie1234',
            'name' => 'Jessie Doe',
            'email' => 'jessie@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ])->assertJsonValidationErrors('account_name');

        $this->assertDatabaseMissing('users', [
            'account_name' => 'jessie1234',
            'name' => 'Jessie Doe',
            'email' => 'jessie@example.com'
        ]);
    }
}
