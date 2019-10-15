<?php

namespace Tests\Unit;

use App\Professeur;

use database\Factory\ProfesseursFactory;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfesseursTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testCountProfessors() {
        $this->assertEquals(5, Professeur::count());
    }

    public function testInsertIntoProfessors() 
    {
       $professor = factory(\App\Professeur::class)->create();

       $this->assertDatabaseHas('professeurs', [
           'acronyme' => $professor->acronyme,
           'nom' => $professor->nom,
           'prenom' => $professor->prenom
       ]);
    }

}
