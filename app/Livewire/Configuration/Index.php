<?php

namespace App\Livewire\Configuration;

use App\Models\Configuration;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $busca = '';
    public $filtroStatus = '';

    public function mount()
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);
    }

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
        $query = Configuration::withCount(['users', 'properties', 'people', 'contracts']);

        if ($this->busca) {
            $query->where('name', 'like', '%' . $this->busca . '%');
        }

        if ($this->filtroStatus) {
            $query->where('status', $this->filtroStatus);
        }

        $configurations = $query->orderBy('name')->paginate(10);

        return view('livewire.configuration.index', [
            'configurations' => $configurations,
        ]);
    }
}