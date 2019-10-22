<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Session;
use Tests\TestCase;

class ProfessorCsvTest extends TestCase
{
    use RefreshDatabase;
    public function test_import_file()
    {
        Session::start();
        $response = $this->json('POST', '/uploadFile', array(
            'file' => UploadedFile::fake()->create('profs.csv', 500),
        ));
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('professeurs');
    }
}
