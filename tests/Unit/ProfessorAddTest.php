<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Professeur;

class ProfessorAddTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_add_professor()
    {
        $user = factory(User::class)->create();
        $professor = factory(Professeur::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/professeurs', [
            'acronyme' => $professor->acronyme,
            'first_name' => $professor->nom,
            'last_name' => $professor->prenom,
        ]);

        //$response->asserStatus(302);

        $this->assertDatabaseHas('professeurs', [
            'acronyme' => $professor->acronyme,
        ]);
    }


}
