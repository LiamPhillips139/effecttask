<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PagesController extends Controller
{
    public function __invoke(): \Inertia\Response
    {
        return Inertia::render('Solution');
    }

}
