<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|string|max:14|unique:users,cpf')]
    public string $cpf = '';

    #[Rule('required|email|max:255|unique:users,email')]
    public string $email = '';

    #[Rule('nullable|string|max:20')]
    public string $phone = '';

    #[Rule('required|in:standard,Administrador,SuperAdmin')]
    public string $role = 'standard';

    #[Rule('required|in:active,inactive')]
    public string $status = 'active';

    #[Rule('required|string|min:8')]
    public string $password = '';

    public function mount()
    {
        abort_unless(Auth::user()->isAdmin() || Auth::user()->isSuperAdmin(), 403);
    }

    public function save()
    {
        $this->validate();

        User::create([
            'uuid' => (string) Str::uuid(),
            'configuration_id' => Auth::user()->configuration_id,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'status' => $this->status,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('success', 'Usuário criado com sucesso!');

        return redirect()->route('admin.user.index');
    }

    public function render()
    {
        return view('livewire.users.create');
    }
}
