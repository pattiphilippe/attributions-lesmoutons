<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Groupe;

use Tests\TestCase;

use Illuminate\Support\Facades\DB;

class GroupeTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testCountGroupes() {
        $this->assertEquals(10, Groupe::count());
    }

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

        $this->assertEquals($count, 110);
    }

    public function testUniqueName()
    {

        $group = factory(\App\Groupe::class)->create();
        $this->expectException(\PDOException::class);
        factory(\App\Groupe::class)->create([
            'nom' => $group->nom,
        ]);

    }
}