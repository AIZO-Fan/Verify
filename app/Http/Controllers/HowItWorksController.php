<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HowItWorksController extends Controller
{
    /**
     * Display the "How It Works" informational page.
     */
    public function index(): View
    {
        return view('how-it-works.index');
    }
}
