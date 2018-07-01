<?php

namespace Tests\Browser\Auth;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends DuskTestCase
{
    use WithFaker, DatabaseTransactions, DatabaseMigrations;

    /**
     * Test the registration flow goes as expected
     *
     * @test
     */
    public function testVisitorCanRegisterAnAccount()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit('/register')
                ->type($this->faker->name, 'name')
                ->type($this->faker->firstname, 'account_name')
                ->type($this->faker->email, 'email')
                ->type('secret', 'password')
                ->type('secret', 'password_confirmation')
                ->press('Register')
                ->on(new HomePage)
                ->see('Thanks for signing up.');
        });
    }
}
