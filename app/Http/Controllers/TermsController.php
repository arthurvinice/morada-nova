<?php

namespace App\Http\Controllers;

use App\Models\Terms;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function show()
    {
        return view('terms.show');
    }

    public function showPublic()
    {
        $terms = Terms::latest()->first();
        return view('terms.public', compact('terms'));
    }
}
