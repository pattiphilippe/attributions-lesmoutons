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
    public function testAccueil()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Please sign in');
        });
    }

    public function testInscription()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->click('#register-button')
                ->assertPathIs('/register');
        });
    }

    public function testInscriptionEmailDejaPris()
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

    public function testInscriptionMdpConfirmationEchoue()
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

    public function testConnexionEchoue()
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

    public function testConnexionChampsVide()
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

    public function testInscriptionChampsVide()
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

    public function testConnexionReussie()
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

    public function testInscriptionReussie()
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
