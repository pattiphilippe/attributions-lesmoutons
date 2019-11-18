<?php

namespace Tests\Unit;

use Tests\TestCase;

class AttributionAddTest extends TestCase
{

    public function test_add_attribution()
    {
        $user = factory(\App\User::class)->create();
        $professor = factory(\App\Professeur::class)->create();
        $course = factory(\App\Course::class)->create();
        $group = factory(\App\Groupe::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/attributions', [
            'professor' => $professor->acronyme,
            'course' => $course->id,
            'group' => $group->nom,
        ]);

        $this->assertDatabaseHas('attributions', [
            'professor_acronyme' => $professor->acronyme,
        ]);
    }
}
