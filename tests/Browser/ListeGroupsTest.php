<?php

namespace Tests\Browser;

use App\Groupe;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ListeGroupsTest extends DuskTestCase
{

    use DatabaseMigrations;

    /**
     * testContainsSeederInfo
     *
     * @return void
     */
    public function testTitle()
    {

        $user = factory(\App\User::class)->create();
        factory(Groupe::class, 100)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/groupes')
                ->assertSee('Liste de groupes');
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testWithoutGroupes()
    {
        $user = factory(\App\User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/groupes')
                ->assertTitle('Liste de groupes')
                ->assertSee('La liste est vide');
        });
    }

}
