<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Attribution;
use App\Course;
use App\Groupe;
use App\Professeur;
use App\Attribution;
use App\User;

class AttributionGroupingTest extends DuskTestCase
{

    private function initTables($course, $teacher, $group)
    {
        factory(Course::class)->create(["id" => $course]);
        factory(Professeur::class)->create(["acronyme" => $teacher]);
        factory(Groupe::class)->create(["nom" => $group]);
    }


    private function createAttribution($course, $teacher, $group)
    {
        $this->initTables($course, $teacher, $group);
        return factory(Attribution::class)->create([
            "professor_acronyme" => $teacher,
            "course_id" => $course,
            "group_id" => $group,
        ]);
    }



    public function testExample()
    {
        $user = factory(User::class)->create();

        $attributions = [
            $this->createAttribution("WEBG5", "JLC", "E12"),
            $this->createAttribution("DEV4", "NVS", "E11"),
            $this->createAttribution("SYSG5", "MBA", "E12"),
            $this->createAttribution("WEBG5", "JLC", "E11"),
            $this->createAttribution("PRJG5", "SRV", "E12"),
        ];

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/attributions')
        }

    }

}
