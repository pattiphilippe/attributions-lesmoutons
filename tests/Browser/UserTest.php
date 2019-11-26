<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function test_index()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Please sign in');
        });
    }

    public function test_connection_failed()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email', 'frefrefr@gmail.com')
                ->type('password', 'password')
                ->click('#login-button')
                ->waitForText('These credentials do not match our records')
                ->assertSee('These credentials do not match our records');
        });
    }

    public function test_connection_empty_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->type('email', '')
                ->type('password', '')
                ->click('#login-button')
                ->waitForText('The email field is required.')
                ->waitForText('The password field is required.')
                ->assertSee('The email field is required.')
                ->assertSee('The password field is required.');
        });
    }


    public function test_connection_success()
    {
        $user = factory(\App\User::class)->create([
            'email' => 'test@laravel.com',
        ]);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->click('#login-button')
                ->assertPathIs('/home');
        });
    }
}
