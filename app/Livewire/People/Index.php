<?php

namespace App\Livewire\People;

use App\Models\People;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $busca = '';
    public $filtroCidade = '';

    public function updatingBusca()
    {
        $this->resetPage();
    }

    public function updatingFiltroCidade()
    {
        $this->resetPage();
    }

    public function limparFiltros()
    {
        $this->reset(['busca', 'filtroCidade']);
        $this->resetPage();
    }

    public function render()
    {
        $query = People::whereHas('activeContract')
            ->with('activeContract.property');

        if ($this->busca) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->busca . '%')
                    ->orWhere('cpf', 'like', '%' . $this->busca . '%');
            });
        }

        if ($this->filtroCidade) {
            $query->whereHas('activeContract.property', function ($q) {
                $q->where('city', $this->filtroCidade);
            });
        }

        $people = $query->orderBy('name')->paginate(10);

        $cidades = People::whereHas('activeContract')
            ->with('activeContract.property')
            ->get()
            ->pluck('activeContract.property.city')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('livewire.people.index', [
            'people'  => $people,
            'cidades' => $cidades,
        ]);
    }
}