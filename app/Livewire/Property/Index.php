<?php

namespace App\Livewire\Property;

use App\Models\Property;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $properties = Property::with('propertyType', 'activeContract.people')->get();

        return view('livewire.property.index', [
            'properties' => $properties,
        ]);
    }
}