<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        return view('properties.index');
    }

    public function create()
    {
        return view('properties.create');
    }

    public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }
}
