<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocumentsControllerTest extends TestCase
{
    public function test_no_document_chosen(): void
    {
        Storage::fake(); // Use a fake disk for testing

        $response = $this->post('/documents/upload', [
            // Missing 'document' field
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['document']);

    }

    public function test_invalid_document_type(): void
    {
        Storage::fake(); // Use a fake disk for testing

        $file = UploadedFile::fake()->create('test-document.txt', 100, 'text/plain'); // Upload a text file instead of a PDF

        $response = $this->post('/documents/upload', [
            'document' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors(['document']);
    }

    public function test_create_document_successful(): void
    {
        Storage::fake(); // Use a fake disk for testing

        $pdfPath = storage_path('app/public/cvliamphillips.pdf');

        $file = new UploadedFile($pdfPath, 'cvliamphillips.pdf', 'application/pdf', null, true);

        $response = $this->post(route('documents.upload'), [
            'document' => $file
        ]);

        $response->assertStatus(302);
        $response->assertRedirect();

        // Assert that the document was saved correctly
        $this->assertDatabaseHas('documents', [
            'title' => 'cvliamphillips.pdf',
        ]);

    }
}
