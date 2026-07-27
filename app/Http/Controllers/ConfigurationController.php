<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('configuration.index'); //view exclusiva do superAdmin
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('configuration.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Configuration $configuration)
    {
        return view('configuration.store', compact('configuration'));
    }
}
