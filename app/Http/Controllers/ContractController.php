<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        return view('contract.index');
    }

    public function create()
    {
        return view('contract.create');
    }

    public function edit(Contract $contract)
    {
        return view('contract.edit', compact('contract'));
    }
}
