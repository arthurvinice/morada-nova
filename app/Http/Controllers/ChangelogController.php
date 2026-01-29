<?php

namespace App\Http\Controllers;

use App\Models\Changelog;
use App\Models\ChangelogCategory;
use Illuminate\Http\Request;

class ChangelogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $changelogs = Changelog::latest()->get();

        return view('changelog.index', compact('changelogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ChangelogCategory::all();
        return view('changelog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'versao' => 'required|string|max:255|unique:changelog,versao',
            'data_lancamento' => 'nullable|date',
            'categorias' => 'nullable|array',
            'categorias.*' => 'nullable|array',
            'categorias.*.*' => 'nullable|string|max:1000'
        ]);

        $categorias = [];
        if ($request->has('categorias')) {
            foreach ($request->categorias as $categoryId => $descriptions) {
                $cleanDescriptions = array_filter($descriptions, fn($desc) => !empty(trim($desc)));
                if (!empty($cleanDescriptions)) {
                    $categorias[$categoryId] = array_values($cleanDescriptions);
                }
            }
        }

        Changelog::create([
            'versao' => $request->versao,
            'data_lancamento' => $request->data_lancamento,
            'categorias' => $categorias ?: null
        ]);

        return redirect()->route('admin.changelog.index')
            ->with('success', 'Changelog criado com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
