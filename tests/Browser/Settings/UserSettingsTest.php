<?php

namespace Tests\Browser\Settings;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserSettingsTest extends DuskTestCase
{
    use WithFaker, DatabaseMigrations, DatabaseTransactions;

    /**
     * Test updating the user information
     *
     * @test
     */
    public function testUpdatingUserInformation()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/settings')
                    ->clickLink('User')
                    ->assertQueryStringHas('#user')
                    ->assertInputValue('#grid-name', $user->name)
                    ->assertInputValue('#grid-email', $user->email)
                    ->type('John Doe', 'name')
                    ->type('john@example.com', 'email')
                    ->press('Update')
                    ->assertInputValue('#grid-name', 'John Doe')
                    ->assertInputValue('#grid-email', 'john@example.com');
        });
    }

    /**
     * Test deleting the current user
     *
     * @test
     */
    public function testDeletingUserAndAccount()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/settings')
                    ->clickLink('User')
                    ->press('Delete')
                    ->seePageIs('/')
                    ->assertGuest();
        });
    }

}
