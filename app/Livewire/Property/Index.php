<?php

namespace App\Livewire\Property;

use App\Models\Property;
use App\Models\PropertyType;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $busca = '';
    public $filtroCidade = '';
    public $filtroStatus = '';
    public $filtroTipo = '';

    public function updatingBusca()
    {
        $this->resetPage();
    }

    public function updatingFiltroCidade()
    {
        $this->resetPage();
    }

    public function updatingFiltroStatus()
    {
        $this->resetPage();
    }

    public function updatingFiltroTipo()
    {
        $this->resetPage();
    }

    public function limparFiltros()
    {
        $this->reset(['busca', 'filtroCidade', 'filtroStatus', 'filtroTipo']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Property::with('propertyType', 'activeContract.people');

        if ($this->busca) {
            $query->where(function ($q) {
                $q->where('nickname', 'like', '%' . $this->busca . '%')
                    ->orWhere('street', 'like', '%' . $this->busca . '%');
            });
        }

        if ($this->filtroCidade) {
            $query->where('city', $this->filtroCidade);
        }

        if ($this->filtroStatus) {
            $query->where('status', $this->filtroStatus);
        }

        if ($this->filtroTipo) {
            $query->where('property_type_id', $this->filtroTipo);
        }

        $properties = $query->orderBy('city')->paginate(10);

        $cidades = Property::select('city')->distinct()->orderBy('city')->pluck('city');

        return view('livewire.property.index', [
            'properties'    => $properties,
            'cidades'       => $cidades,
            'propertyTypes' => PropertyType::orderBy('name')->get(),
        ]);
    }
}