<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ListeGroupsTest extends DuskTestCase
{

    /**
     * testContainsSeederInfo
     *
     * @return void
     */
    public function testTitle()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/groupes')
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
        $this->browse(function (Browser $browser) {
            $browser->visit('/groupes')
                    ->assertSee('Liste de groupes')
                    ->press('#accueilBtn')
                    ->assertRouteIs('accueil');
        });
    }



    /**
     * testContainsSeederInfo
     *
     * @return void
     */
    public function testContainsSeederInfo()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/groupes')
                    ->assertSee('Liste de groupes')
                    ->assertSee('A1')
                    ->assertSee('A11')
                    ->assertSee('A111')
                    ->assertSee('A112')
                    ->assertSee('B1')
                    ->assertSee('B11')
                    ->assertSee('B111')
                    ->assertSee('B112')
                    ->assertSee('B2')
                    ->assertSee('B21');
        });
    }
}
