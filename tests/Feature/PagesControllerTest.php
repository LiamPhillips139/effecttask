<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PagesControllerTest extends TestCase
{
    public function test_shows_solution_page(): void
    {
        $this
            ->get('/')
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Solution')
                    ->where('errors', [])
            );
    }

    public function test_returns_errors_when_fields_fail_validation(): void
    {
        $this->get('/');

        $this
            ->followingRedirects()
            ->post(route('documents.upload'))
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Solution')
                    ->where('errors.document', 'The document field is required.')
            );
    }

    public function test_pdf_upload_successful_and_redirects_back_with_flash_message(): void
    {
        $this->get('/');

        Storage::fake(); // Use a fake disk for testing

        $pdfPath = storage_path('app/public/cvliamphillips.pdf');
        $uploadedFile = new UploadedFile($pdfPath, 'cvliamphillips.pdf', 'application/pdf', null, true);

        $this
            ->followingRedirects()
            ->post(route('documents.upload'), [
                'document' => $uploadedFile,
            ])
            ->assertOk()
            ->assertInertia(
                fn (AssertableInertia $page) => $page
                    ->component('Solution')
                    ->where('flash.message', 'Your PDF document was successfully uploaded.')
            );


    }
}
