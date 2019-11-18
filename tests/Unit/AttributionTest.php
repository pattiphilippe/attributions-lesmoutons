<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Course;
use database\Factory\CourseFactory;
use App\Groupe;
use database\Factory\GroupeFactory;
use App\Professeur;
use database\Factory\ProfesseurFactory;
use App\Attribution;
use database\Factory\AttributionRawFactory;


class AttributionTest extends TestCase
{

    use RefreshDatabase;

    private function initTables()
    {
        factory(Course::class)->create();
        factory(Groupe::class)->create();
        factory(Professeur::class)->create();
    }

    public function testCreateValidAttribution()
    {
        $this->initTables();
        $inserted = factory(Attribution::class)->states('randomForeignKeys')->create();
        $fetched = Attribution::find($inserted->id)->first();
        $this->assertEquals($inserted->id, $fetched->id);
        $this->assertEquals(
            $inserted->professor_acronyme,
            $fetched->professor_acronyme
        );
        $this->assertEquals($inserted->course_id, $fetched->course_id);
        $this->assertEquals($inserted->group_id, $fetched->group_id);
        $this->assertEquals($inserted->quadrimester, $fetched->quadrimester);
    }

    public function testCreateAttributionWithExistingId()
    {
        $this->initTables();
        $inserted = factory(Attribution::class)->states('randomForeignKeys')->create();
        $this->expectException(\PDOException::class);
        factory(Attribution::class)->create(
            ['id' => $inserted->id]
        );
    }

    public function testCreateAttributionViolatesUniqueConstraint()
    {
        $this->initTables();
        $inserted = factory(Attribution::class)->states('randomForeignKeys')->create();
        $this->expectException(\PDOException::class);
        factory(Attribution::class)->create(
            ['groupe_id' => $inserted->groupe_id,
            'course_id' => $inserted->course_id,
            'quadrimester' => $inserted->quadrimester
            ]
        );
    }

    public function testCreateAttributionViolatesProfessorFK()
    {
        $course = factory(Course::class)->create();
        $groupe = factory(Groupe::class)->create();
        $this->expectException(\PDOException::class);
        factory(Attribution::class)->states('randomForeignKeys')->create(['professor_id' => 'SRV']);
    }

    public function testCreateAttributionViolatesCourseFK()
    {
        $groupe = factory(Groupe::class)->create();
        $professor = factory(Professeur::class)->create();
        $this->expectException(\PDOException::class);
        factory(Attribution::class)->states('randomForeignKeys')->create(['course_id' => 'PRJG5']);
    }

    public function testCreateAttributionViolatesGroupFK()
    {
        $course = factory(Course::class)->create();
        $professor = factory(Professeur::class)->create();
        $this->expectException(\PDOException::class);
        factory(Attribution::class)->states('randomForeignKeys')->create(['groupe_id' => 'E11']);
    }

    public function testDeleteAttribution()
    {
        $this->initTables();
        $inserted = factory(Attribution::class)->states('randomForeignKeys')->create();
        Attribution::destroy($inserted->id);
        $this->assertDatabaseMissing('attributions', ['id'=> $inserted->id]);
    }

    public function testUpdateAttributionViolatesProfessorFK()
    {
        $this->initTables();
        $inserted = factory(Attribution::class)->states('randomForeignKeys')->create();
        $fetched = Attribution::find($inserted->id)->first();
        $fetched->professor_acronyme = 'SRV';
        $this->expectException(\PDOException::class);
        $fetched->save();
    }

    public function testUpdateAttributionViolatesCourseFK()
    {
        $this->initTables();
        $inserted = factory(Attribution::class)->states('randomForeignKeys')->create();
        $fetched = Attribution::find($inserted->id)->first();
        $fetched->course_id = 'PRJG5';
        $this->expectException(\PDOException::class);
        $fetched->save();
    }

    public function testUpdateAttributionViolatesGroupFK()
    {
        $this->initTables();
        $inserted = factory(Attribution::class)->states('randomForeignKeys')->create();
        $fetched = Attribution::find($inserted->id)->first();
        $fetched->group_id = 'E11';
        $this->expectException(\PDOException::class);
        $fetched->save();
    }

}
