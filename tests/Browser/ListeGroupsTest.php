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
     * testGroupsReturnAccueil
     *
     * @return void
     */
    public function testGroupsReturnAccueil()
    {
        $user = factory(\App\User::class)->create();
        factory(Groupe::class, 100)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/groupes')
                ->assertSee('Liste de groupes')
                ->click('#accueilBtn')
                ->waitForLocation('/home');
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

    public function testWithGroupDeleted()
    {
        $user = factory(\App\User::class)->create();
        $group = factory(Groupe::class)->create([
            'nom' => 'A1',
        ]);
        $this->browse(function (Browser $browser) use ($user, $group) {
            $browser->loginAs($user)
                ->visit('/groupes')
                ->assertTitle('Liste de groupes')
                ->click('#delete_button')
                ->assertDontSee($group->nom);
        });
    }

}
