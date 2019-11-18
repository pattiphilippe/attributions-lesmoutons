<?php

namespace Tests\Unit;

use App\Course;
use App\Groupe;
use App\Professeur;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttributionAddTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_attribution()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/attributions', [
            'professor' => $professor->acronyme,
            'course' => $course->id,
            'group' => $group->nom,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('attributions', [
            'professor_acronyme' => $professor->acronyme,
        ]);
    }

    public function test_wrong_data()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/attributions', [
            'professor' => "EEE",
            'course' => "AAA",
            'group' => "A19",
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('attributions', [
            'professor_acronyme' => "EEE",
            'course_id' => "AAA",
            'group_id' => "A19",
        ]);
    }

    public function test_data_missing()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/attributions', [
            'professor' => "",
            'course' => "",
            'group' => "",
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('attributions', [
            'professor_acronyme' => "",
            'course_id' => "",
            'group_id' => "",
        ]);
    }

    public function test_professor_already_gives_course_group()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/attributions', [
            'professor' => $professor->acronyme,
            'course' => $course->id,
            'group' => $group->nom,
        ]);

        $response = $this->json('POST', '/attributions', [
            'professor' => $professor->acronyme,
            'course' => $course->id,
            'group' => $group->nom,
        ]);

        $response->assertStatus(422);
    }

    public function test_course_given_by_another_professor_to_group()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();
        $professor2 = factory(Professeur::class)->create();
        $course = factory(Course::class)->create();
        $group = factory(Groupe::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/attributions', [
            'professor' => $professor->acronyme,
            'course' => $course->id,
            'group' => $group->nom,
        ]);

        $response = $this->json('POST', '/attributions', [
            'professor' => $professor2->acronyme,
            'course' => $course->id,
            'group' => $group->nom,
        ]);

        $response->assertStatus(422);
    }

}
