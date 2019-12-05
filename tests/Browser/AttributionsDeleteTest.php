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

class AttributionsDeleteTest extends DuskTestCase
{

    use DatabaseMigrations;


    public function test_delete_attribution_success()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->click("#delete-{$attribution['id']}")
                ->acceptDialog()
                ->waitForLocation('/attributions')
                ->assertSee('Attribution supprimée avec succès !');
        });
    }

    public function test_delete_attribution_withDismissDialog()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->click("#delete-{$attribution['id']}")
                ->dismissDialog()
                ->waitForLocation('/attributions')
                ->assertDontSee('Attribution supprimée avec succès !')
                ->assertSee($attribution->professor_acronyme);
        });
    }

    public function test_delete_attribution_success_withDismissDialog_andAfterAccept()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->click("#delete-{$attribution['id']}")
                ->dismissDialog()
                ->waitForLocation('/attributions')
                ->assertDontSee('Attribution supprimée avec succès !')
                ->click("#delete-{$attribution['id']}")
                ->acceptDialog()
                ->assertSee('Attribution supprimée avec succès !');
        });
    }

    public function test_delete_attribution_success_withSelectByGroup()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->select('#select-groupby','group')
                ->pause(300)
                ->click("#delete-{$attribution['id']}")
                ->acceptDialog()
                ->waitForLocation('/attributions')
                ->assertSee('Attribution supprimée avec succès !');
        });
    }


    public function test_delete_attribution_dismissDialog_withSelectByGroup()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->select('#select-groupby','group')
                ->pause(300)
                ->click("#delete-{$attribution['id']}")
                ->dismissDialog()
                ->waitForLocation('/attributions')
                ->assertDontSee('Attribution supprimée avec succès !');
        });
    }

    public function test_delete_attribution_success_withSelectByCourse()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create([
            'id' => 'DEV1',
        ]);
        $group = factory(Groupe::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->select("#select-groupby","course")
                ->pause(300)
                ->click("#delete-{$attribution['id']}")
                ->acceptDialog()
                ->waitForLocation('/attributions')
                ->assertSee('Attribution supprimée avec succès !');
        });
    }

    public function test_delete_attribution_dismissDialog_withSelectByCourse()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create([
            'id' => 'DEV1',
        ]);
        $group = factory(Groupe::class)->create();

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);

        $this->browse(function (Browser $browser) use ($user,$attribution) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->select("#select-groupby","course")
                ->pause(300)
                ->click("#delete-{$attribution['id']}")
                ->dismissDialog()
                ->waitForLocation('/attributions')
                ->assertDontSee('Attribution supprimée avec succès !');
        });
    }

}