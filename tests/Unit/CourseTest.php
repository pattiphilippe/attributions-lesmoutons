<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Course;

// TODO: use factories
// TODO: add a test case for the maximum number of credits
class CourseTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Checks if a course is inserted as expected.
     */
    public function testAddCourse()
    {
        $data=[
            'id' => 'PRJG5',
            'title' => 'Cours de gestion de projet',
            'credits' => '6',
            'BM1_hours' => '24',
            'BM2_hours' => '24'
        ];
        Course::create($data);
        $course = Course::find('PRJG5');
        $this->assertDatabaseHas('courses', $data);
    }

    /**
     * Expects a PDOException on constraint violation.
     */
    public function testAddCourseWithExistingId()
    {
        $firstCourse=[
            'id' => 'PRJG5',
            'title' => 'Cours de gestion de projet',
            'credits' => '6',
            'BM1_hours' => '24',
            'BM2_hours' => '24'
        ];
        $secondCourse=[
            'id' => 'PRJG5',
            'title' => 'Cours de XP',
            'credits' => '6',
            'BM1_hours' => '24',
            'BM2_hours' => '24'
        ];
        Course::create($firstCourse);
        $this->expectException(\PDOException::class);
        Course::create($secondCourse);
    }

    /**
     * Checks if a course is deleted as expected.
     */
    public function testDeleteCourse()
    {
        $data=[
            'id' => 'PRJG5',
            'title' => 'Cours de gestion de projet',
            'credits' => '6',
            'BM1_hours' => '24',
            'BM2_hours' => '24'
        ];
        Course::create($data);
        $course = Course::destroy('PRJG5');
        $this->assertDatabaseMissing('courses', $data);
    }

    /**
     * Checks if a course is updated as expected.
     */
    public function testUpdateCourse()
    {
        $data=[
            'id' => 'PRJG5',
            'title' => 'Cours de gestion de projet',
            'credits' => '6',
            'BM1_hours' => '24',
            'BM2_hours' => '24'
        ];
        $dataUpdate = [
            'id' => 'DEV3',
            'title' => 'Dévloppement3',
            'credits' => '5',
            'BM1_hours' => '34',
            'BM2_hours' => '12'
        ];
        
        Course::create($data);
        $course = Course::find('PRJG5')->update($dataUpdate);
        $this->assertDatabaseHas('courses', $dataUpdate);        
    }
    
    /**
     * Expects a PDOException on constraint violation.
     */
    public function testAddCourseWithExistingTitle()
    {
        $firstCourse=[
            'id' => 'DEV4',
            'title' => 'Developement 4',
            'credits' => '6',
            'BM1_hours' => '24',
            'BM2_hours' => '24'
        ];
        $secondCourse=[
            'id' => 'DEV3',
            'title' => 'Developement 4',
            'credits' => '3',
            'BM1_hours' => '12',
            'BM2_hours' => '12'
        ];
        Course::create($firstCourse);
        $this->expectException(\PDOException::class);
        Course::create($secondCourse);
    }

}
