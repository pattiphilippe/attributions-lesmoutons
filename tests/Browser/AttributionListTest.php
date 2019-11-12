<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Attribution;

class AttributionListTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testWithAttributions()
    {
        $user = factory(\App\User::class)->create();
        factory(Attribution::class, 100)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->assertTitle('Liste des attributions')
                ->assertSee('Professeur Acronyme')
                ->assertSee('Cours')
                ->assertSee('Groupe')
                ->assertSee('Quadrimestre');
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testWithoutAttributions()
    {
        $user = factory(\App\User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->assertTitle('Liste des attributions')
                ->assertSee('La liste est vide');
        });
    }
}

