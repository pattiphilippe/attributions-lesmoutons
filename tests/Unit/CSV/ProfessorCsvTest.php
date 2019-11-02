<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProfessorCSVTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_file_wrong_content()
    {
        $user = Factory('App\User')->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('uploads/csv_import_prof.csv', 24);

        $response = $this->json('POST', '/uploadFile', [
            'file' => $file,
        ]);

        $response->assertSessionHas('warning', 'The content of the file is inappropriate and cannot be processed. Check if it\'s well formated and the data is correct');
        $response->assertSessionMissing('success');
    }

    public function test_import_file_missing()
    {
        $user = Factory('App\User')->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('uploads/csv_import_prof.csv', 24);

        $response = $this->json('POST', '/uploadFile', [
            // 'file' => $file,
        ]);

        $response->assertSessionHas('warning', 'Please choose a file');
        $response->assertSessionMissing('success');
    }

    public function test_import_file_to_heavy()
    {
        $user = Factory('App\User')->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('uploads/csv_import_prof.csv', 2897152);

        $response = $this->json('POST', '/uploadFile', [
            'file' => $file,
        ]);

        $response->assertSessionHas('warning', 'File too large. File must be less than 2MB');
        $response->assertSessionMissing('success');
    }

    public function test_import_file_wrong_extension()
    {
        $user = Factory('App\User')->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('csv_import_prof.pdf', 24);

        $response = $this->json('POST', '/uploadFile', [
            'file' => $file,
        ]);

        $response->assertSessionHas('warning', 'Invalid File Extension');
        $response->assertSessionMissing('success');
    }

    // public function test_import_file()
    // {
    //     $user = Factory('App\User')->create();
    //     $this->actingAs($user);

    //     Storage::fake('local');

    //     $filePath = 'random_prof.csv';

    //     file_put_contents($filePath, "acronyme,nom,prenom\nJDO,Doe,John");

    //     // $fileContent = array(
    //     //     array("acronyme", "nom", "prenom"),
    //     //     array("JDO", "Doe", "John"),
    //     // );

    //     // $file = UploadedFile::fake()->create('uploads/csv_import_prof.csv', 24);

    //     // dd($file);

    //     // foreach ($fileContent as $line) {
    //     //     fputcsv($file->tempFile, $line);
    //     // }

    //     $response = $this->json('POST', '/uploadFile', [
    //         // 'file' => $file,
    //         'file' => new UploadedFile($filePath, 'random_prof.csv', null, null, null, true),
    //     ]);

    //     dd($this->app['session.store']);

    //     // $response->dump();
    //     // $response->dumpHeaders();

    //     $response->assertSessionHas('success');
    //     // $response->assertSessionMissing('warning');

    //     // Storage::disk('local')->assertExists($file->hashName());
    //     $this->assertDatabaseHas('professeurs', [
    //         'acronyme' => 'JDO',
    //         'nom' => 'Doe',
    //         'prenom' => 'John',
    //     ]);
    // }
}
