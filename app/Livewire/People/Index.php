<?php

namespace App\Livewire\People;

use App\Models\People;
use Livewire\Component;

class Index extends Component
{
    public $filtroCidade;

    public function render()
    {
        $people = People::with('contracts.property', 'activeContract.property')->get();

        return view('livewire.people.index', [
            'people' => $people
        ]);
    }
}