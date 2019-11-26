<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CourseCsvTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_file_empty()
    {
        $user = Factory('App\User')->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('uploads/csv_import_course.csv', 24);

        $response = $this->json('POST', '/uploadFileCourse', [
            'file' => $file,
        ]);

        $response->assertSessionHas('success', 'Import Successful');
        $response->assertSessionMissing('warning');
    }

    public function test_import_file_missing()
    {
        $user = Factory('App\User')->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('uploads/csv_import_course.csv', 24);

        $response = $this->json('POST', '/uploadFileCourse', [
            // 'file' => $file,
        ]);

        $response->assertSessionHas('warning', 'Please choose a file');
        $response->assertSessionMissing('success');
    }

    public function test_import_file_to_heavy()
    {
        $user = Factory('App\User')->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('uploads/csv_import_course.csv', 2897152);

        $response = $this->json('POST', '/uploadFileCourse', [
            'file' => $file,
        ]);

        $response->assertSessionHas('warning', 'File too large. File must be less than 2MB');
        $response->assertSessionMissing('success');
    }

    public function test_import_file_wrong_extension()
    {
        $user = Factory('App\User')->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->create('csv_import_course.pdf', 24);

        $response = $this->json('POST', '/uploadFileCourse', [
            'file' => $file,
        ]);

        $response->assertSessionHas('warning', 'Invalid File Extension');
        $response->assertSessionMissing('success');
    }

}