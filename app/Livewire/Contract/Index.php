<?php

namespace App\Livewire\Contract;

use App\Models\Contract;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $busca = '';
    public $filtroStatus = '';

    public function updatingBusca()
    {
        $this->resetPage();
    }

    public function updatingFiltroStatus()
    {
        $this->resetPage();
    }

    public function limparFiltros()
    {
        $this->reset(['busca', 'filtroStatus']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Contract::with('property.propertyType', 'people');

        if ($this->busca) {
            $query->whereHas('people', function ($q) {
                $q->where('name', 'like', '%' . $this->busca . '%')
                    ->orWhere('cpf', 'like', '%' . $this->busca . '%');
            });
        }

        if ($this->filtroStatus) {
            $query->where('status', $this->filtroStatus);
        }

        $contracts = $query->orderBy('start_date', 'desc')->paginate(10);

        return view('livewire.contract.index', [
            'contracts' => $contracts,
        ]);
    }
}