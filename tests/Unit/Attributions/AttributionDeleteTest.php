<?php

namespace Tests\Unit;

use App\Course;
use App\Groupe;
use App\Professeur;
use App\Attribution;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttributionDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_attribution()
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
        $this->actingAs($user);

        $response = $this->call('DELETE', "/attributions/{$attribution['id']}");
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseMissing('attributions', [
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);


    }

    /**
     * Test to delete an attribution after created one with the form
     */
    public function test_delete_attribution_after_created()
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

        $attribution = Attribution::where([
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ])->firstOrFail();

        //Delete here
        $response = $this->call('DELETE', "/attributions/{$attribution['id']}");
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertDatabaseMissing('attributions', [
            'professor_acronyme' => $professor->acronyme,
            'course_id' => $course->id,
            'group_id' => $group->nom,
        ]);


    }

}
