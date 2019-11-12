<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GroupCSVTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_import_csv_group_file_missing()
    {
        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/groupes')
                ->assertSee('Liste de groupes')
                ->click('#import-csv-button')
                ->waitForText('Please choose a file');
        });
    }

    public function test_import_csv_group_file_wrong_content()
    {
        $filePath = 'uploads/random_group.csv';
        file_put_contents($filePath, "acronyme,nm,rrerere\ny§rrurutur");

        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser->loginAs($user)
                ->visit('/groupes')
                ->assertSee('Liste de groupes')
                ->attach('file', $filePath)
                ->click('#import-csv-button')
                ->waitForText('The content of the file is inappropriate and cannot be processed. Check if it\'s well formated and the data is correct');
        });
    }

    public function test_import_csv_group_file_wrong_extension()
    {
        $filePath = 'uploads/random_group.pdf';
        file_put_contents($filePath, "acronyme,nom,prenom\nJDO,Doe,John");

        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser->loginAs($user)
                ->visit('/groupes')
                ->assertSee('Liste de groupes')
                ->attach('file', $filePath)
                ->click('#import-csv-button')
                ->waitForText('Invalid File Extension');
        });
    }

    public function test_import_csv_group_file()
    {
        $filePath = 'uploads/random_group.csv';
        file_put_contents($filePath, "nom\nE943");

        $user = factory(\App\User::class)->create();

        $this->browse(function (Browser $browser) use ($user, $filePath) {
            $browser->loginAs($user)
                ->visit('/groupes')
                ->assertSee('Liste de groupes')
                ->attach('file', $filePath)
                ->click('#import-csv-button')
                ->waitForText('Import Successful')
                ->waitForText('E943')
                ->pause(500);
        });
    }

}
