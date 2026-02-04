<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function index()
    {
        return view('people.index');
    }

    public function create()
    {
        return view('people.create');
    }

    public function edit($id)
    {
        $peopleId = People::findOrFail($id);
        return view('people.edit', compact('peopleId'));
    }
}

