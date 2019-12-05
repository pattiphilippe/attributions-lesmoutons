<?php

namespace Tests\Browser;

use App\Course;
use App\Attribution;
use App\Groupe;
use App\Professeur;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CoursesListTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test with a course attributed to 1 group and there exist only 1 group so the course is considered to be attributed
     *
     * @return void
     */
    public function testWithCoursesAttributed()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(Course::class)->create([
            'id' => 'DONG5',
        ]);
        $groupe = factory(Groupe::class)->create([
            'nom' => 'A2',
        ]);
        factory(Attribution::class)->create([
            'course_id' => $course->id,
            'group_id' => $groupe->nom,
        ]);
        $this->browse(function (Browser $browser) use ($user, $course) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertTitle('Liste des Cours')
                ->select('filter', 'coursesNonAttributed')
                ->assertDontSee($course->id)
                ->select('filter', 'coursesAttributed')
                ->assertSee($course->id);
        });
    }

    /**
     * Test with a course attributed to 1 group and there exist  2 group so the course is considered to be not attributed
     *
     * @return void
     */
    public function testWithCoursesNonAttributed()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(Course::class)->create([
            'id' => 'DONG5',
        ]);
        $groupe = factory(Groupe::class)->create([
            'nom' => 'A2',
        ]);
        factory(Groupe::class)->create([
            'nom' => 'A3',
        ]);
        factory(Attribution::class)->create([
            'course_id' => $course->id,
            'group_id' => $groupe->nom,
        ]);
        $this->browse(function (Browser $browser) use ($user, $course) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertTitle('Liste des Cours')
                ->select('filter', 'coursesNonAttributed')
                ->assertSee($course->id)
                ->select('filter', 'coursesAttributed')
                ->assertDontSee($course->id);
        });
    }

    /**
     * Test with a course attributed and course not attributed tested with all filters
     *
     * @return void
     */
    public function testWithAllCoursesAttributedAndNot()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(Course::class)->create([
            'id' => 'DONG5',
        ]);
        $course2 = factory(Course::class)->create([
            'id' => 'MOBG5',
        ]);
        $groupe = factory(Groupe::class)->create([
            'nom' => 'A2',
        ]);
        $groupe2 = factory(Groupe::class)->create([
            'nom' => 'A3',
        ]);
        factory(Attribution::class)->create([
            'course_id' => $course->id,
            'group_id' => $groupe->nom,
        ]);
        factory(Attribution::class)->create([
            'course_id' => $course->id,
            'group_id' => $groupe2->nom,
        ]);
        factory(Attribution::class)->create([
            'course_id' => $course2->id,
            'group_id' => $groupe->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user, $course, $course2) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertTitle('Liste des Cours')
                ->select('filter', 'coursesNonAttributed')
                ->assertSee($course2->id)
                ->assertDontSee($course->id)
                ->select('filter', 'coursesAttributed')
                ->assertSee($course->id)
                ->assertDontSee($course2->id)
                ->select('filter', 'courses')
                ->assertSee($course2->id)
                ->assertSee($course->id);
        });
    }

    public function testWithCourseDeleted()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(Course::class)->create([
            'id' => 'DONG5',
        ]);
        $this->browse(function (Browser $browser) use ($user, $course) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertTitle('Liste des Cours')
                ->click('#delete_button')
                ->assertDontSee($course->id);
        });
    }
}
