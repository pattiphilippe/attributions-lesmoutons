<?php

namespace Tests\Browser;

use App\Course;
use App\Attribution;
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

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testWithCoursesAttributed()
    {
        $user = factory(\App\User::class)->create();
        $attribution = factory(Attribution::class)->create();
        $this->browse(function (Browser $browser) use ($user, $attribution) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertTitle('Liste des Cours')
                ->select('filter', 'coursesAttributed')
                ->assertSee($attribution->course_id);
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testWithCoursesNonAttributed()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(Course::class)->create();
        $this->browse(function (Browser $browser) use ($user, $course) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertTitle('Liste des Cours')
                ->select('filter', 'coursesNonAttributed')
                ->assertSee($course->id);
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testWithCoursesNonAttributedDontSee()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(Course::class)->create();
        $this->browse(function (Browser $browser) use ($user, $course) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertTitle('Liste des Cours')
                ->select('filter', 'coursesAttributed')
                ->assertDontSee($course->id);
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testWithCoursesAttributedDontSee()
    {
        $user = factory(\App\User::class)->create();
        $attribution = factory(Attribution::class)->create();
        $this->browse(function (Browser $browser) use ($user, $attribution) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertTitle('Liste des Cours')
                ->select('filter', 'coursesNonAttributed')
                ->assertDontSee($attribution->course_id);
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testWithCoursesSeeWithoutFilter()
    {
        $user = factory(\App\User::class)->create();
        $attribution = factory(Attribution::class)->create();
        $course = factory(Course::class)->create();
        $this->browse(function (Browser $browser) use ($user, $attribution, $course) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertTitle('Liste des Cours')
                ->select('filter', 'courses')
                ->assertSee($attribution->course_id)
                ->assertSee($course->id);
        });
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testWithAllCourseAttributedWithFilterNonAttributed()
    {
        $user = factory(\App\User::class)->create();
        $attribution = factory(Attribution::class, 20)->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertTitle('Liste des Cours')
                ->select('filter', 'coursesNonAttributed')
                ->assertSee('La liste est un peu vide!');
        });
    }
}
