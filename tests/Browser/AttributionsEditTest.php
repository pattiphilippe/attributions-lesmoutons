<?php

namespace Tests\Browser;

use App\Course;
use App\Groupe;
use App\Professeur;
use App\User;
use App\Attribution;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AttributionsEditTest extends DuskTestCase
{

    use DatabaseMigrations;

    public function test_edit_course_attribution_success()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();
        $course2 =factory(Course::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution,$professor,$course,$group,$course2) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->click("#edit-{$attribution['id']}")
                ->waitForLocation("/attributions/{$attribution['id']}/edit")
                ->assertSee("Edition de l'Attribution")
                ->select('professor', $professor->acronyme)
                ->select('course', $course2->id) // we edit the course here
                ->select('group', $group->nom)
                ->click('#submit-update-attribution')
                ->waitForLocation('/attributions')
                ->assertDontSee($course->id)
                ->assertSee($course2->id)
                ->assertSee("Attribution mise à jour avec succès !");
        });
    }

    public function test_edit_group_attribution_success()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();
        $group2 =factory(Groupe::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution,$professor,$course,$group2,$group) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->click("#edit-{$attribution['id']}")
                ->waitForLocation("/attributions/{$attribution['id']}/edit")
                ->assertSee("Edition de l'Attribution")
                ->select('professor', $professor->acronyme)
                ->select('course', $course->id)
                ->select('group', $group2->nom)  // we edit the group here
                ->click('#submit-update-attribution')
                ->waitForLocation('/attributions')
                ->assertDontSee($group->nom)
                ->assertSee($group2->nom)
                ->assertSee("Attribution mise à jour avec succès !");
        });
    }

    public function test_edit_professor_attribution_success()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();
        $professor2 =factory(Professeur::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution,$professor,$course,$professor2,$group) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->click("#edit-{$attribution['id']}")
                ->waitForLocation("/attributions/{$attribution['id']}/edit")
                ->assertSee("Edition de l'Attribution")
                ->select('professor', $professor2->acronyme)  // we edit the professor here
                ->select('course', $course->id)
                ->select('group', $group->nom) 
                ->click('#submit-update-attribution')
                ->waitForLocation('/attributions')
                ->assertDontSee($professor->acronyme)
                ->assertSee($professor2->acronyme)
                ->assertSee("Attribution mise à jour avec succès !");
        });
    }

    public function test_edit_allData_attribution_success()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $professor2 =factory(Professeur::class)->create();
        $course2 = factory(Course::class)->create();
        $group2 = factory(Groupe::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution,$professor,$course,$professor2,$group,$group2,$course2) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->click("#edit-{$attribution['id']}")
                ->waitForLocation("/attributions/{$attribution['id']}/edit")
                ->assertSee("Edition de l'Attribution")
                ->select('professor', $professor2->acronyme)  //edit
                ->select('course', $course2->id) //edit
                ->select('group', $group2->nom) //edit
                ->click('#submit-update-attribution')
                ->waitForLocation('/attributions')
                ->assertDontSee($professor->acronyme)
                ->assertDontSee($course->id)
                ->assertDontSee($group->nom)
                ->assertSee($professor2->acronyme)
                ->assertSee($course2->id)
                ->assertSee($group2->nom)
                ->assertSee("Attribution mise à jour avec succès !");
        });
    }

     public function test_edit_allData_attribution_alreadyGiven()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $professor2 =factory(Professeur::class)->create();
        $course2 = factory(Course::class)->create();
        $group2 = factory(Groupe::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $attribution2 = factory(Attribution::class)->create([
            'professor_acronyme' => $professor2->acronyme,
            'course_id' => $course2->id,
            'group_id' => $group2->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution,$attribution2) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->click("#edit-{$attribution['id']}")
                ->waitForLocation("/attributions/{$attribution['id']}/edit")
                ->assertSee("Edition de l'Attribution")
                ->select('professor', $attribution2->professor_acronyme)  //edit
                ->select('course', $attribution2->course_id) //edit
                ->select('group', $attribution2->group_id) //edit
                ->click('#submit-update-attribution')
                ->waitForLocation("/attributions/{$attribution['id']}/edit")
                ->assertDontSee("Attribution mise à jour avec succès !")
                ->assertSee("Le professeur {$attribution2['professor_acronyme']} donne déjà ce cours à ce groupe.");
        });
    }

    public function test_edit_courseGroup_attribution_alreadyGiven()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $professor2 =factory(Professeur::class)->create();
        $course2 = factory(Course::class)->create();
        $group2 = factory(Groupe::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $attribution2 = factory(Attribution::class)->create([
            'professor_acronyme' => $professor2->acronyme,
            'course_id' => $course2->id,
            'group_id' => $group2->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution,$attribution2) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->click("#edit-{$attribution['id']}")
                ->waitForLocation("/attributions/{$attribution['id']}/edit")
                ->assertSee("Edition de l'Attribution")
                ->select('professor', $attribution->professor_acronyme) 
                ->select('course', $attribution2->course_id) //edit
                ->select('group', $attribution2->group_id) //edit
                ->click('#submit-update-attribution')
                ->waitForLocation("/attributions/{$attribution['id']}/edit")
                ->assertDontSee("Attribution mise à jour avec succès !")
                ->assertSee("Un professeur est déjà attribué à ce cours et ce groupe.");
        });
    }

    /**
     * Scenario : The two professor gives differents courses to the same group 
     * but we try to edit the course of the professor #1 to the same course of professor #2
     */
    public function test_edit_course_attribution_alreadyGiven()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $professor2 =factory(Professeur::class)->create();
        $course2 = factory(Course::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $attribution2 = factory(Attribution::class)->create([
            'professor_acronyme' => $professor2->acronyme,
            'course_id' => $course2->id,
            'group_id' => $group->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution,$attribution2) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->click("#edit-{$attribution['id']}")
                ->waitForLocation("/attributions/{$attribution['id']}/edit")
                ->assertSee("Edition de l'Attribution")
                ->select('professor', $attribution->professor_acronyme) 
                ->select('course', $attribution2->course_id) //edit
                ->select('group', $attribution->group_id) 
                ->click('#submit-update-attribution')
                ->waitForLocation("/attributions/{$attribution['id']}/edit")
                ->assertDontSee("Attribution mise à jour avec succès !")
                ->assertSee("Un professeur est déjà attribué à ce cours et ce groupe.");
        });
    }

    /**
     * Scenario : The two professor gives same course but differents group
     * but we try to edit the group of the professor #1 to the same group of professor #2
     */
    public function test_edit_group_attribution_alreadyGiven()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $group = factory(Groupe::class)->create();
        $course= factory(Course::class)->create();
        $professor2 =factory(Professeur::class)->create();
        $group2 = factory(Groupe::class)->create();


        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $attribution2 = factory(Attribution::class)->create([
            'professor_acronyme' => $professor2->acronyme,
            'course_id' => $course->id,
            'group_id' => $group2->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution,$attribution2) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->click("#edit-{$attribution['id']}")
                ->waitForLocation("/attributions/{$attribution['id']}/edit")
                ->assertSee("Edition de l'Attribution")
                ->select('professor', $attribution->professor_acronyme) 
                ->select('course', $attribution->course_id) 
                ->select('group', $attribution2->group_id) //edit
                ->click('#submit-update-attribution')
                ->waitForLocation("/attributions/{$attribution['id']}/edit")
                ->assertDontSee("Attribution mise à jour avec succès !")
                ->assertSee("Un professeur est déjà attribué à ce cours et ce groupe.");
        });
    }




}