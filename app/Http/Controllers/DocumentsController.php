<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        return redirect()->back()->with([
            'message' => 'success'
        ]);
    }
}
