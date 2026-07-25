<?php

namespace App\Livewire\Property;

use App\Models\Property;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        if (auth()->user()->role == 'SuperAdmin') {
            $properties = Property::with('propertyType', 'activeContract.people')->get();
        } else {
            $properties = Property::where('user_id', auth()->user()->id)
                ->with('propertyType', 'activeContract.people')
                ->get();
        }

        return view('livewire.property.index', [
            'properties' => $properties,
        ]);
    }
}