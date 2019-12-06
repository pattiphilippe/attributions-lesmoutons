<?php

namespace Tests\Browser;

use App\Attribution;
use App\Course;
use App\Groupe;
use App\Professeur;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AttributionGroupingTest extends DuskTestCase
{
    use DatabaseMigrations;

    private function initTables()
    {
        factory(Course::class)->create(["id" => "WEBG5"]);
        factory(Course::class)->create(["id" => "DEV4"]);
        factory(Course::class)->create(["id" => "SYSG5"]);
        factory(Course::class)->create(["id" => "PRJG5"]);
        factory(Professeur::class)->create(["acronyme" => "JLC"]);
        factory(Professeur::class)->create(["acronyme" => "NVS"]);
        factory(Professeur::class)->create(["acronyme" => "MBA"]);
        factory(Professeur::class)->create(["acronyme" => "SRV"]);
        factory(Groupe::class)->create(["nom" => "E11"]);
        factory(Groupe::class)->create(["nom" => "E12"]);
    }

    private function createAttribution($course, $teacher, $group)
    {
        return factory(Attribution::class)->create([
            "professor_acronyme" => $teacher,
            "course_id" => $course,
            "group_id" => $group,
        ]);
    }

    public function testGroupingByGroupWorkTest()
    {
        $this->initTables();
        $user = factory(User::class)->create();

        $attributions = [
            $this->createAttribution("WEBG5", "JLC", "E12"),
            $this->createAttribution("DEV4", "NVS", "E11"),
            $this->createAttribution("SYSG5", "MBA", "E12"),
            $this->createAttribution("WEBG5", "JLC", "E11"),
            $this->createAttribution("PRJG5", "SRV", "E12"),
        ];

        $this->browse(function (Browser $browser) use ($user, $attributions) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->select('groupby', 'course')
                ->select('groupby', 'group')
                ->waitForText('E11')
                ->assertPresent('#table-E12')
                ->assertPresent('#table-E11');
        });

    }

    public function testGroupingByGroupWorkTitlesTest()
    {
        $this->initTables();
        $user = factory(User::class)->create();

        $attributions = [
            $this->createAttribution("WEBG5", "JLC", "E12"),
            $this->createAttribution("DEV4", "NVS", "E11"),
            $this->createAttribution("SYSG5", "MBA", "E12"),
            $this->createAttribution("WEBG5", "JLC", "E11"),
            $this->createAttribution("PRJG5", "SRV", "E12"),
        ];

        $this->browse(function (Browser $browser) use ($user, $attributions) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->select('groupby', 'course')
                ->select('groupby', 'group')
                ->waitForText('E11')
                ->assertSeeIn('h3:nth-of-type(1)', 'E12')
                ->assertSeeIn('h3:nth-of-type(2)', 'E11');
        });
    }

    public function testGroupingByGroupEmptyAttributions()
    {
        $user = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->assertSee('La liste est vide');
        });
    }

    public function testGroupingByCourseWorkTest()
    {
        $this->initTables();
        $user = factory(User::class)->create();

        $attributions = [
            $this->createAttribution("WEBG5", "JLC", "E12"),
            $this->createAttribution("DEV4", "NVS", "E11"),
            $this->createAttribution("SYSG5", "MBA", "E12"),
            $this->createAttribution("WEBG5", "JLC", "E11"),
            $this->createAttribution("DEV4", "SRV", "E12"),
        ];

        $this->browse(function (Browser $browser) use ($user, $attributions) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->select('groupby', 'group')
                ->select('groupby', 'course')
                ->waitForText('E11')
                ->assertPresent('#table-WEBG5')
                ->assertPresent('#table-DEV4')
                ->assertPresent('#table-SYSG5');
        });

    }

    public function testGroupingByCourseWorkTitlesTest()
    {
        $this->initTables();
        $user = factory(User::class)->create();

        $attributions = [
            $this->createAttribution("WEBG5", "JLC", "E12"),
            $this->createAttribution("DEV4", "NVS", "E11"),
            $this->createAttribution("SYSG5", "MBA", "E12"),
            $this->createAttribution("WEBG5", "JLC", "E11"),
            $this->createAttribution("DEV4", "SRV", "E12"),
        ];

        $this->browse(function (Browser $browser) use ($user, $attributions) {
            $browser->loginAs($user)
                ->visit('/attributions')
                ->select('groupby', 'group')
                ->select('groupby', 'course')
                ->waitForText('E11')
                ->assertSeeIn('h3:nth-of-type(1)', 'WEBG5')
                ->assertSeeIn('h3:nth-of-type(2)', 'DEV4')
                ->assertSeeIn('h3:nth-of-type(3)', 'SYSG5');
        });
    }

}
