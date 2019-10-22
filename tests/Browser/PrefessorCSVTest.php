<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfessorCSVTest extends DuskTestCase
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
            $browser->visit('/professeurs')
                ->assertSee('Liste de professeurs');
        });
    }

    public function testImportButton()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/professeurs')
                ->click('#file-button')
                ->pause(2000)
                ->assertPathIs('/professeurs');
        });
    }

}
