<?php

namespace App\Livewire\People;

use App\Models\People;
use Livewire\Component;

class Index extends Component
{
    public $filtroCidade;

    public function render()
    {
        if (auth()->user()->role == 'SuperAdmin') {
            $people = People::all();
        } else {
            $people = People::where('user_id', auth()->user()->id)->get();
        }
        return view('livewire.people.index', [
            'people' => $people
        ]);
    }
}
