<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ListeGroupsTest extends DuskTestCase
{

    use DatabaseMigrations;

    public function setUp() : void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

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

}
