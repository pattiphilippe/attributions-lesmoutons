<?php

namespace Tests\Browser;

use App\Course;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

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
        $user = factory(\App\User::class)->create();
        factory(Course::class, 100)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/courses')
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
        $user = factory(\App\User::class)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertTitle('Liste des Cours')
                ->assertSee('La liste est un peu vide!');
        });
    }
}
