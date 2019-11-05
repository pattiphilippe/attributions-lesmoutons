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

    public function test_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('#register-button')
                ->assertPathIs('/register');
        });
    }

    public function test_register_email_already_taken()
    {
        $user = factory(\App\User::class)->create([
            'email' => 'test@laravel.com',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/register')
                ->type('email', $user->email)
                ->type('#inputPassword', 'password')
                ->type('#inputConfirmPassword', 'password')
                ->click('#register-button')
                ->waitForText('The email has already been taken.')
                ->assertSee('The email has already been taken.');
        });
    }

    public function test_register_password_confirmation_failed()
    {
        $user = factory(\App\User::class)->create([
            'email' => 'test@laravel.com',
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/register')
                ->type('email', $user->email)
                ->type('#inputPassword', 'password')
                ->type('#inputConfirmPassword', 'TEST1234')
                ->click('#register-button')
                ->waitForText('The password confirmation does not match.')
                ->assertSee('The password confirmation does not match.');
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

    public function test_register_empty_fields()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', '')
                ->type('#inputPassword', '')
                ->type('#inputConfirmPassword', '')
                ->click('#register-button')
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

    public function test_register_success()
    {

        $this->browse(function ($browser) {
            $browser->visit('/register')
                ->type('email', 'test@gmail.com')
                ->type('#inputPassword', 'password')
                ->type('#inputConfirmPassword', 'password')
                ->click('#register-button')
                ->assertPathIs('/home');
        });

    }
}
