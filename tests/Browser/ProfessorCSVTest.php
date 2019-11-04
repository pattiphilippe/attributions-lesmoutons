<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ProfessorCSVTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_import_csv_prof_file_missing()
    {
        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/professeurs')
                ->assertSee('Liste de professeurs')
                ->click('#import-csv-button')
                ->waitForText('Please choose a file');
        });
    }

    public function test_import_csv_prof_file_wrong_content()
    {
        $filePath = 'uploads/random_prof.csv';
        file_put_contents($filePath, "acronyme,nm,rrerere\nJDO,Doe");

        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser->loginAs($user)
                ->visit('/professeurs')
                ->assertSee('Liste de professeurs')
                ->attach('file', $filePath)
                ->click('#import-csv-button')
                ->waitForText('The content of the file is inappropriate and cannot be processed. Check if it\'s well formated and the data is correct');
        });
    }

    public function test_import_csv_prof_file_wrong_extension()
    {
        $filePath = 'uploads/random_prof.pdf';
        file_put_contents($filePath, "acronyme,nom,prenom\nJDO,Doe,John");

        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser->loginAs($user)
                ->visit('/professeurs')
                ->assertSee('Liste de professeurs')
                ->attach('file', $filePath)
                ->click('#import-csv-button')
                ->waitForText('Invalid File Extension');
        });
    }

    public function test_import_csv_prof_file()
    {
        $filePath = 'uploads/random_prof.csv';
        file_put_contents($filePath, "acronyme,nom,prenom\nJDO,Doe,John");

        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser->loginAs($user)
                ->visit('/professeurs')
                ->assertSee('Liste de professeurs')
                ->attach('file', $filePath)
                ->click('#import-csv-button')
                ->waitForText('Import Successful')
                ->waitForText('JDO')
                ->waitForText('Doe')
                ->waitForText('John')
                ->pause(500);
        });
    }

}
