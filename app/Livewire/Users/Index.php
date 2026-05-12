<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $busca = '';
    public $filtroStatus = '';

    public function limparFiltros()
    {
        $this->reset(['busca', 'filtroStatus']);
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query();

        if ($this->busca) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->busca . '%')
                    ->orWhere('email', 'like', '%' . $this->busca . '%');
            });
        }

        if ($this->filtroStatus) {
            $query->where('status', $this->filtroStatus);
        }

        $users = $query
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.users.index', [
            'users' => $users
        ]);
    }
}