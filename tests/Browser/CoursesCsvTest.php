<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\DB;


class CoursesCsvTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_import_csv_courses_file_missing()
    {
        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertSee('Liste des Cours')
                ->click('#import-csv-button')
                ->waitForText('Please choose a file');
        });
    }

    public function test_import_csv_courses_file_wrong_content()
    {
        $filePath = 'uploads/random_courses.csv';
        file_put_contents($filePath, "acronyme,nm,rrerere,eeuhu,dede,ede\nJDO,Doe,eded,eded,eded,edd");

        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertSee('Liste des Cours')
                ->attach('file', $filePath)
                ->click('#import-csv-button')
                ->waitForText('The content of the file is inappropriate and cannot be processed. Check if it\'s well formated and the data is correct');
        });
    }

    public function test_import_csv_courses_file_wrong_extension()
    {
        $filePath = 'uploads/random_courses.pdf';
        file_put_contents($filePath, "id,title,credits,BM1_hours,BM2_hours\DEV2,devel,10,10,10");

        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertSee('Liste des Cours')
                ->attach('file', $filePath)
                ->click('#import-csv-button')
                ->waitForText('Invalid File Extension');
        });
    }

    public function test_import_csv_courses_file()
    {
        $filePath = 'uploads/random_courses.csv';
        file_put_contents($filePath, "id,title,credits,BM1_hours,BM2_hours\nDEV2,devel,10,10,10");

        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertSee('Liste des Cours')
                ->attach('file', $filePath)
                ->click('#import-csv-button')
                ->waitForText('Import Successful')
                ->waitForText('DEV2')
                ->waitForText('devel')
                ->waitForText('10')
                ->waitForText('10')
                ->waitForText('10')
                ->pause(500);
        });
    }
    
    public function test_import_csv_delete_table()
    {
        $filePath = 'uploads/random_courses.csv';
        file_put_contents($filePath, "id,title,credits,BM1_hours,BM2_hours\nDEV2,devel,10,10,10");
        DB::table('courses')->insert([
            'id' => 'DEV1',
            'title' => 'Dévloppement',
            'credits' => '10',
            'BM1_hours' => '30',
            'BM2_hours' => '30',
        ]);
        $user = factory(\App\User::class)->create();
        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser->loginAs($user)
                ->visit('/courses')
                ->assertSee('Liste des Cours')
                ->attach('file', $filePath)
                ->click('#import-csv-button')
                ->waitForText('Import Successful')
                ->waitForText('DEV2')
                ->assertDontSee('DEV1');
        });
    }

}
