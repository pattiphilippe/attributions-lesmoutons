<?php

namespace Tests\Unit;

use App\Course;
use App\Groupe;
use App\Professeur;
use App\Attribution;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttributionEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_Alldata_attribution()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $professor2 = factory(Professeur::class)->create();
        $course2 = factory(Course::class)->create();
        $group2 = factory(Groupe::class)->create();


        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);
        $this->actingAs($user);

        $response =
        $this->json('PUT',"/attributions/{$attribution['id']}", [
            'professor' => $professor2->acronyme,
            'course' => $course2->id,
            'group' => $group2->nom,
        ]);

        // We check that the initials values doesnt exit anymore
        $this->assertDatabaseMissing('attributions', [
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);


    }

    public function test_edit_course_attribution()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $course2 = factory(Course::class)->create();
        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);
        $this->actingAs($user);

        $response =
        $this->json('PUT',"/attributions/{$attribution['id']}", [
            'professor' => $professor->acronyme,
            'course' => $course2->id,
            'group' => $group->nom,
        ]);

        // We check that the initials values doesnt exit anymore
        $this->assertDatabaseMissing('attributions', [
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);


    }

    public function test_edit_group_attribution()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $group2 = factory(Groupe::class)->create();
        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);
        $this->actingAs($user);

        $response =
        $this->json('PUT',"/attributions/{$attribution['id']}", [
            'professor' => $professor->acronyme,
            'course' => $course->id,
            'group' => $group2->nom,
        ]);

        // We check that the initials values doesnt exit anymore
        $this->assertDatabaseMissing('attributions', [
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);


    }

    public function test_edit_alldata_alreadyGiven_attribution_()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $professor2 = factory(Professeur::class)->create();
        $course2 = factory(Course::class)->create();
        $group2 = factory(Groupe::class)->create();

        $attribution2 = factory(Attribution::class)->create([
            'professor_acronyme' => $professor2->acronyme,
            'course_id' => $course2->id,
            'group_id' => $group2->nom,
        ]);

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);
        $this->actingAs($user);

        $response =
        $this->json('PUT',"/attributions/{$attribution['id']}", [
            'professor' => $professor2->acronyme,
            'course' => $course2->id,
            'group' => $group2->nom,
        ]);

        $response->assertStatus(422);



    }


    public function test_edit_courseGroup_alreadyGivenByAnotherProfessor_attribution_()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $professor2 = factory(Professeur::class)->create();
        $course2 = factory(Course::class)->create();
        $group2 = factory(Groupe::class)->create();

        $attribution2 = factory(Attribution::class)->create([
            'professor_acronyme' => $professor2->acronyme,
            'course_id' => $course2->id,
            'group_id' => $group2->nom,
        ]);

        $attribution = factory(Attribution::class)->create([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);
        $this->actingAs($user);

        //We checks if we cannot edit to an attribution with course-groupe already given by another professor
        $response =
        $this->json('PUT',"/attributions/{$attribution['id']}", [
            'professor' => $professor->acronyme,
            'course' => $course2->id,
            'group' => $group2->nom,
        ]);

        $response->assertStatus(422);
        }

        /**
         * Test to edit the group of an attribution but the pair group-course already given by another professor
         */
        public function test_edit_group_alreadyGivenByAnotherProfessor_attribution_()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $professor2 = factory(Professeur::class)->create();
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
        $this->actingAs($user);

        $response =
        $this->json('PUT',"/attributions/{$attribution['id']}", [
            'professor' => $professor->acronyme,
            'course' => $course->id,
            'group' => $group2->nom,
        ]);

        $response->assertStatus(422);
        }


         /**
         * Test to edit the course of an attribution but the pair group-course already given by another professor
         */
        public function test_edit_course_alreadyGivenByAnotherProfessor_attribution_()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $course2 = factory(Course::class)->create();
        $professor2 = factory(Professeur::class)->create();


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
        $this->actingAs($user);

        $response =
        $this->json('PUT',"/attributions/{$attribution['id']}", [
            'professor' => $professor->acronyme,
            'course' => $course2->id,
            'group' => $group->nom,
        ]);

        $response->assertStatus(422);
        }




}
