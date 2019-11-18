<?php

namespace Tests\Browser;

use App\Course;
use App\Groupe;
use App\Professeur;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AttributionsAddTest extends DuskTestCase
{

    use DatabaseMigrations;

    public function test_add_attribution_success()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $this->browse(function (Browser $browser) use ($user, $professor, $course, $group) {
            $browser->loginAs($user)
                ->visit('/attributions/create')
                ->select('professor', $professor->acronyme)
                ->select('course', $course->id)
                ->select('group', $group->nom)
                ->click('#submit-add-attribution')
                ->waitForLocation('/attributions')
                ->assertSee($professor->acronyme);
        });
    }

    public function test_missing_data()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/attributions/create')
                ->click('#submit-add-attribution')
                ->waitForLocation('/attributions/create')
                ->assertSee("Le champ professor est obligatoire.")
                ->assertSee("Le champ course est obligatoire.")
                ->assertSee("Le champ group est obligatoire.");
        });
    }

    public function test_professor_already_gives_course_group()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();
        DB::table('attributions')->insert([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
            'quadrimester' => 2, //TODO Change the value once the schema is updated.
        ]);

        $this->browse(function (Browser $browser) use ($user, $professor, $course, $group) {
            $browser->loginAs($user)
                ->visit('/attributions/create')
                ->select('professor', $professor->acronyme)
                ->select('course', $course->id)
                ->select('group', $group->nom)
                ->click('#submit-add-attribution')
                ->waitForLocation('/attributions/create')
                ->assertSee("Le professeur " . $professor->acronyme . " donne déjà ce cours à ce groupe.");
        });
    }

    public function test_course_given_by_another_professor_to_group()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $professor2 = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();
        DB::table('attributions')->insert([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
            'quadrimester' => 2, //TODO Change the value once the schema is updated.
        ]);

        $this->browse(function (Browser $browser) use ($user, $professor, $professor2, $course, $group) {
            $browser->loginAs($user)
                ->visit('/attributions/create')
                ->select('professor', $professor2->acronyme)
                ->select('course', $course->id)
                ->select('group', $group->nom)
                ->click('#submit-add-attribution')
                ->waitForLocation('/attributions/create')
                ->assertSee("Un professeur est déjà attribué à ce cours et ce groupe.");
        });
    }

}
