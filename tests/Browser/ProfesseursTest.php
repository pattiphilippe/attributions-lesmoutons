<?php

namespace Tests\Browser;

use App\Professeur;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfesseursTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testProfesseursPage()
    {
        $user = factory(\App\User::class)->create();
        factory(Professeur::class, 100)->create();
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
        factory(Professeur::class, 100)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/professeurs')
                ->assertSee('Liste de professeurs')
                ->press('#accueilBtn')
                ->waitForLocation('/home');
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
        factory(Professeur::class, 100)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/professeurs')
                ->assertSee('Liste de professeurs');
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testWithoutProfesseurs()
    {
        $user = factory(\App\User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/professeurs')
                ->assertTitle('Liste de professeurs')
                ->assertSee('La liste est vide');
        });
    }

    public function testWithProfDeleted()
    {
        $user = factory(\App\User::class)->create();
        $prof = factory(Professeur::class)->create([
            'acronyme' => 'ABS',
        ]);
        $this->browse(function (Browser $browser) use ($user, $prof) {
            $browser->loginAs($user)
                ->visit('/professeurs')
                ->assertTitle('Liste de professeurs')
                ->click('#delete_button')
                ->assertDontSee($prof->acronyme);
        });
    }

}
