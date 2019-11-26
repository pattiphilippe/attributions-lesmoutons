<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Course;
use App\Professeur;
use App\Groupe;
use App\Attribution;
use App\Controllers\ServiceController;

class ServiceControllerTest extends TestCase
{

    use RefreshDatabase;

    private function login() {
        $user = factory(\App\User::class)->create();
        $this->actingAs($user);
    }

    public function testJSONAttributionsList()
    {
        $this->login();
        $first = factory(Attribution::class)->create();
        $second = factory(Attribution::class)->create();
        $third = factory(Attribution::class)->create();
        
        $response = $this->json('GET', '/api/attributions');

        $response->assertStatus(200)
                ->assertJsonCount(3)
                ->assertJson([
                    0 => [
                        "id" => $first->id, 
                        "professor_acronyme" => $first->professor_acronyme,
                        "course_id" => $first->course_id,
                        "group_id" => $first->group_id,
                    ],
                    1 => [
                        "id" => $second->id, 
                        "professor_acronyme" => $second->professor_acronyme,
                        "course_id" => $second->course_id,
                        "group_id" => $second->group_id,
                    ],
                    2 => [
                        "id" => $third->id, 
                        "professor_acronyme" => $third->professor_acronyme,
                        "course_id" => $third->course_id,
                        "group_id" => $third->group_id,
                    ],
                ]);
    }

    public function testJSONNoAttributions()
    {
        $this->login();
        $response = $this->json('GET', '/api/attributions');
        $response->assertStatus(200)
                ->assertJsonCount(0);
    }

    public function testJSONOnlyOneAttribution()
    {
        $this->login();
        $first = factory(Attribution::class)->create();
        $response = $this->json('GET', '/api/attributions');
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                0 => [
                    "id" => $first->id, 
                    "professor_acronyme" => $first->professor_acronyme,
                    "course_id" => $first->course_id,
                    "group_id" => $first->group_id,
                ],
            ]);
    }

}
