<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfesseursTest extends DuskTestCase
{

    use DatabaseMigrations;

    public function setUp(): void
    {

        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testProfesseursPage()
    {
        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/professeurs')
                ->assertSee('Liste de professeurs');
        });
    }

    /**
     * testProfesseursReturnAccueil
     *
     * @return void
     */
    public function testProfesseursReturnAccueil()
    {
        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/professeurs')
                ->assertSee('Liste de professeurs')
                ->press('#accueilBtn')
                ->assertRouteIs('home');
        });
    }

    /**
     * testProfesseursContainsSeederInfo
     *
     * @return void
     */
    public function testProfesseursContainsSeederInfo()
    {
        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/professeurs')
                ->assertSee('Liste de professeurs');
        });
    }

}
