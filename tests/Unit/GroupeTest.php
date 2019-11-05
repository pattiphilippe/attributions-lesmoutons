<?php

namespace Tests\Unit;

use App\Groupe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Support\Facades\DB;

class GroupeTest extends TestCase
{

    use RefreshDatabase;

    public function testInsertIntoGroupes() 
    {
       $groupe = factory(\App\Groupe::class)->create();

       $this->assertDatabaseHas('groupes', [
           'nom' => $groupe->nom,
       ]);
    }

    public function testInsertMultipleIntoGroupes()
    {
        factory(\App\Groupe::class, 100)->create();

        $count = DB::table('groupes')->count();

        $this->assertEquals($count, 100);
    }

    public function testUniqueName()
    {

        $group = factory(\App\Groupe::class)->create();
        $this->expectException(\PDOException::class);
        factory(\App\Groupe::class)->create([
            'nom' => $group->nom,
        ]);

    }

    public function testDeleteGroupe()
    {
        $group = factory(\App\Groupe::class)->create();
        Groupe::destroy($group->nom);
        $this->assertDatabaseMissing('groupes', [
            'nom' => $group->nom,
        ]);
    }


    public function testUpdateGroupe() 
    {
        $group = factory(\App\Groupe::class)->create();

        $newName = 'Patricia';
        $groupToUpdate = Groupe::find($group->nom);
        $groupToUpdate->nom = $newName;
        $groupToUpdate->save();
       
        $this->assertDatabaseHas('groupes', [
            'nom' => $newName,
        ]);
    }

}