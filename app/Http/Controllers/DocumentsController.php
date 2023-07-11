<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Aws\Textract\TextractClient;
use Aws\Textract\Exception\TextractException;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DocumentsController extends Controller
{

    public function __invoke(Request $request): RedirectResponse
    {

        $request->validate([
            'document' => 'required'
        ]);

        $file = $request->file('document');

        if($file->getClientMimeType() !== 'application/pdf') {
            return redirect()->back()->withErrors([
                'document' => 'Please only upload PDF documents.'
            ]);
        }

        try {

            $textractClient = new TextractClient([
                'region' => 'eu-west-2',
                'version' => 'latest',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY')
                ]
            ]);

            $startTime = Carbon::now();

            $result = $textractClient->detectDocumentText([
                'Document' => [
                    'Bytes' => $file->get()
                ]
            ]);

            $blocks = $result->get('Blocks');

            $text = '';

            foreach($blocks as $block) {
                if ($block['BlockType'] != 'WORD') {
                    continue;
                }

                $text .= $block['Text'] . ' ';

            }

            $document = new Document();

            $document->title = $file->getClientOriginalName();
            $document->text = $text;
            $document->request_start_time = $startTime;
            $document->created_at = Carbon::now();
            $document->updated_at = Carbon::now();

            $document->save();

        } catch(TextractException $e) {

            Log::error('Textract Exception: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'message' => 'There was an issue with the amazon web services client. Please try again later.'
            ]);

        } catch (\Throwable $e) {

            Log::error('General Exception: ' . $e->getMessage());

            return redirect()->back()->withErrors([
                'message' => 'Unable to process your request at this time. Please try again later.'
            ]);

        }

        return redirect()->back()->with([
            'message' => 'Your PDF document was successfully uploaded.'
        ]);
    }
}
