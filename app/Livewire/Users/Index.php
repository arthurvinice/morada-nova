<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $logado = Auth::user();

        if ($logado->nivel == 'SuperAdmin') {
            $users = User::orderBy('id', 'desc')
                ->paginate(10);
        }

        $users = User::orderBy('id', 'desc')->paginate(10);

        return view('livewire.users.index', [
            'users' => $users
        ]);
    }
}
