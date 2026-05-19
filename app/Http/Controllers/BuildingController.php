<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        return view('building.index');
    }

    public function create()
    {
        return view('building.create');
    }

    public function edit(Request $building)
    {
        $building = Building::findOrFail($building->id);
        return view('building.edit', compact('building'));
    }
}
