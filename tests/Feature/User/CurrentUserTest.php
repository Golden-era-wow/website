<?php

namespace Tests\Feature\User;

use App\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatingCurrentUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function canUpdateMyDetails()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $this->json('PUT', route('api.current-user.update'), [
            'name' => 'James doe',
            'email' => 'james@example.com'
        ])->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'James doe',
            'email' => 'james@example.com'
        ]);
    }

    /** @test */
    public function canUpdateMyEmailWithoutChangingIt()
    {
        $this->actingAs($user = factory(User::class)->create(['email' => 'james@example.com']), 'api');

        $this->json('PUT', route('api.current-user.update'), [
            'name' => 'James doe',
            'email' => 'james@example.com'
        ])->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'James doe',
            'email' => 'james@example.com'
        ]);
    }

    /** @test */
    public function cannotChangeToAnothersEmail()
    {
        factory(User::class)->create(['email' => 'admin@example.com']);

        $this->actingAs($user = factory(User::class)->create(), 'api');

        $this->json('PUT', route('api.current-user.update'), [
            'email' => 'admin@example.com'
        ])->assertJsonValidationErrors('email');

        $this->assertDatabaseMissing('users', ['id' => $user->id, 'email' => 'admin@example.com']);
    }

    /** @test */
    public function canDestroyMyUser()
    {
        $this->actingAs($user = factory(User::class)->states('with API access')->create(), 'api');

        $this->json('DELETE', route('api.current-user.destroy'))->assertRedirect('/');

        // I can verify the tokens are revoked, but can't really do much to test they're no longer usable..
        // $this->assertGuest('api');
        // $this->json('GET', route('api.current-user.show'))->assertStatus(401);

        $this->assertSoftDeleted('users', ['id' => $user->id]);

        $this->assertDatabaseHas(Passport::client()->getTable(), [
            'user_id' => $user->id,
            'revoked' => true
        ]);

        $this->assertDatabaseHas(Passport::token()->getTable(), [
            'user_id' => $user->id,
            'revoked' => true
        ]);
    }

}
