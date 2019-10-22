<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Course;

class CoursesListTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testWithCourses()
    {
        factory(Course::class, 100)->create();
        $this->browse(function (Browser $browser) {
            $browser->visit('/courses')
                    ->assertTitle('Liste des Cours')
                    ->assertSee('Acronyme')
                    ->assertSee('Titre')
                    ->assertSee('Ects')
                    ->assertSee("Nombre d'heures pour le 1er bimestre")
                    ->assertSee("Nombre d'heures pour le 2e bimestre");
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testWithoutCourses()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/courses')
                    ->assertTitle('Liste des Cours')
                    ->assertSee('La liste est un peu vide!');
        });
    }
}