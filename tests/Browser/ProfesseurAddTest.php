<?php

namespace Tests\Browser;

use App\Professeur;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\DB;

class ProfesseurAddTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_add_professor()
    {
        $user = factory(User::class)->create();
    //    $professor = factory(Professeur::class)->create();
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/professeurs/create')
                ->type('#acronyme', 'JVO')
                ->type('#nom', 'Julien')
                ->type('#prenom', 'Van Oye')
                ->click('#submit-add-professor')
                ->waitForLocation('/professeurs')
                ->assertSee('JVO');
        });
    }

    public function test_acronym_aready_exists(){
        $user = factory(User::class)->create();
        DB::table('professeurs')->insert([
            'acronyme'=> "JVO",
            'nom' => "Van Oye",
            'prenom' => "Julien"
        ]);
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/professeurs/create')
                ->type('#acronyme', 'JVO')
                ->type('#nom', 'Van Oye')
                ->type('#prenom', 'Julien')
                ->click('#submit-add-professor')
                ->waitForLocation('/professeurs/create')
                ->assertSee('Le professeur JVO existe déjà.');
        });
    }

    public function test_empty_field(){
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/professeurs/create')
                ->click('#submit-add-professor')
                ->waitForLocation('/professeurs/create')
                ->assertSee('Le champ :acronyme est obligatoire')
                ->assertSee('Le champ :nom est obligatoire')
                ->assertSee('The prenom field is required.');

        });
    }
    public function test_add_professor_acronym_to_long()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/professeurs/create')
                ->type('#acronyme', 'JVOO')
                ->type('#nom', 'Julien')
                ->type('#prenom', 'Van Oye')
                ->click('#submit-add-professor')
                ->waitForLocation('/professeurs/create')
                ->assertSee('Le champ acronyme doit être de taille 3.');
        });
    }

    public function test_add_professor_without_name()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user)
                ->visit('/professeurs/create')
                ->type('#acronyme', 'JVOO')
                ->type('#nom', '')
                ->type('#prenom', 'Van Oye')
                ->click('#submit-add-professor')
                ->waitForLocation('/professeurs/create')
                ->assertSee('Le champ :nom est obligatoire');
        });
    }
}
