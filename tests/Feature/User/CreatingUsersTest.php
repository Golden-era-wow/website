<?php

namespace Tests\Feature\User;

use App\Jobs\CreateGameAccountJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class CreatingUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function itDispatchesAJobToRegisterAGameAccountUponRegistration()
    {
        Bus::fake();

        $this->post(
            '/register',
            [
            'account_name' => 'john',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
            ]
        )->assertRedirect('/home');

        Bus::assertDispatched(CreateGameAccountJob::class);
    }
}
