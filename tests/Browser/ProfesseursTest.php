<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfesseursTest extends DuskTestCase
{

    use DatabaseTransactions;


    public function setUp() : void
    {

        parent::setUp();
        $this->artisan('db:seed');
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }

    /**
     * A basic browser test example.
     *
     * @return void
     */
   public function testProfesseursPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/professeurs')
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
        $this->browse(function (Browser $browser) {
            $browser->visit('/professeurs')
            ->assertSee('Liste de professeurs')
            ->press('#accueilBtn')
            ->assertRouteIs('accueil');
        });
    }
    
    /**
     * testProfesseursContainsSeederInfo
     *
     * @return void
     */
    public function testProfesseursContainsSeederInfo()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/professeurs')
            ->assertSee('Liste de professeurs');
        });
    }


}
