<?php

//namespace Tests\Unit;

use App\Professeur;

use database\Factory\ProfesseursFactory;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;

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

    public function testInsertMultipleIntoProfessors() 
    {
        factory(\App\Professeur::class, 100)->create();

        $count = DB::table('professeurs')->count();

        $this->assertEquals($count, 105);
    }

    public function testInsertProfessorWithSameId() 
    {
        $this->expectException(\PDOException::class);

        $professor1 = factory(App\Professeur::class)->create([
            'acronyme' => 'ABS',
            'nom' => 'Absil',
            'prenom' => 'Romain'
        ]);
    }

    public function testDeleteProfessor()
    {
        $professor1 = factory(\App\Professeur::class)->create([
            'acronyme' => 'SDR',
            'nom' => 'Drosbisz',
            'prenom' => 'Sebastien'
        ]);

        Professeur::destroy('SDR');

        $this->assertDatabaseMissing('professeurs', [
            'acronyme' => 'SDR',
            'nom' => 'Drosbisz',
            'prenom' => 'Sebastien',
        ]);
    }


    public function testUpdateProfessor() 
    {

        $professor1 = factory(\App\Professeur::class)->create([
            'acronyme' => 'ARO',
            'nom' => 'Rousseau',
            'prenom' => 'Anne'
        ]);

        $professorToUpdate = Professeur::find('ARO');
        
        $professorToUpdate->prenom = 'Patricia';
        $professorToUpdate->save();
       
        $this->assertDatabaseHas('professeurs', [
            'acronyme' => 'ARO',
            'nom' => 'Rousseau',
            'prenom' => 'Patricia'
        ]);
    }

}
