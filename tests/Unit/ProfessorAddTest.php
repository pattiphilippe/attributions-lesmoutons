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

        $this->assertDatabaseHas('professeurs', [
            'acronyme' => $professor->acronyme,
        ]);
    }

    public function test_wrong_data_acronym()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/professeurs', [
            'acronyme' => "EEEE",
            'first_name' => "Julien",
            'last_name' => "Van Oye",
        ]);

        $this->assertDatabaseMissing('professeurs', [
            'acronyme' => "EEEE",
        ]);
    }

    public function test_first_name_empty()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/professeurs', [
            'acronyme' => "EEE",
            'first_name' => "",
            'last_name' => "Van Oye",
        ]);

        $this->assertDatabaseMissing('professeurs', [
            'acronyme' => "EEE",
        ]);
    }
    public function test_last_name_empty()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/professeurs', [
            'acronyme' => "JVO",
            'first_name' => "Julien",
            'last_name' => "",
        ]);

        $this->assertDatabaseMissing('professeurs', [
            'acronyme' => "JVO",
        ]);
    }

    public function test_acronym_empty()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/professeurs', [
            'acronyme' => "",
            'first_name' => "Julien",
            'last_name' => "Van Oye",
        ]);

        $this->assertDatabaseMissing('professeurs', [
            'acronyme' => "",
        ]);
    }

    public function test_acronym_already_exist()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $response = $this->json('POST', '/professeurs', [
            'acronyme' => "ABS",
            'first_name' => "Anthony",
            'last_name' => "Farci",
        ]);

        $response = $this->json('POST', '/professeurs', [
            'acronyme' => "ABS",
            'first_name' => "Anthony",
            'last_name' => "Farcy",
        ]);

        $this->assertDatabaseMissing('professeurs', [
            'acronyme' => "ABS",
            'nom' => "Anthony",
            'prenom' => "Farcy",
        ]);
    }
    

    
}
