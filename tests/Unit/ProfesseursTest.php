<?php

//namespace Tests\Unit;

use App\Professeur;

use database\Factory\ProfesseursFactory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;

class ProfesseursTest extends TestCase
{

    use RefreshDatabase;

    public function testCountProfessors() {
        $professor = factory(\App\Professeur::class)->create();
        $this->assertEquals(1, Professeur::count());
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

        $this->assertEquals($count, 100);
    }

    public function testInsertProfessorWithSameId() 
    {
        $professor = factory(\App\Professeur::class)->create([
            'acronyme' => 'ABS',
            'nom' => 'Absil',
            'prenom' => 'Romain'
        ]);
        $this->expectException(\PDOException::class);
        factory(\App\Professeur::class)->create([
            'acronyme' => $professor->acronyme,
            'nom' => 'Not Absil',
            'prenom' => 'Not Romain'
        ]);
    }

    public function testDeleteProfessor()
    {
        $professor = factory(\App\Professeur::class)->create([
            'acronyme' => 'SDR',
            'nom' => 'Drosbisz',
            'prenom' => 'Sebastien'
        ]);

        Professeur::destroy($professor->acronyme);

        $this->assertDatabaseMissing('professeurs', [
            'acronyme' => $professor->acronyme,
            'nom' => $professor->nom,
            'prenom' => $professor->prenom
        ]);
    }


    public function testUpdateProfessor() 
    {
        $professor = factory(\App\Professeur::class)->create([
            'acronyme' => 'ARO',
            'nom' => 'Rousseau',
            'prenom' => 'Anne'
        ]);

        $professorToUpdate = Professeur::find($professor->acronyme);
        
        $nouveauPrenom = 'Patricia';
        $professorToUpdate->prenom = $nouveauPrenom;
        $professorToUpdate->save();
       
        $this->assertDatabaseHas('professeurs', [
            'acronyme' => $professor->acronyme,
            'nom' => $professor->nom,
            'prenom' => $nouveauPrenom
        ]);
    }

}
