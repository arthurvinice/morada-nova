<?php

namespace App\Livewire\Users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Show extends Component
{
    public string $name = '';
    public string $email = '';

    public string $currentPassword = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore(Auth::id())],
        ]);

        Auth::user()->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('success', 'Seu perfil foi atualizado com sucesso!');
    }

    public function updatePasswordAction()
    {
        $this->validate([
            'currentPassword' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (! Hash::check($this->currentPassword, Auth::user()->password)) {
            session()->flash('warning', 'A sua senha atual não confere, tentar novamente.');
            return;
        }

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['currentPassword', 'password', 'password_confirmation']);

        session()->flash('success', 'Sua senha foi atualizada com sucesso!');
    }

    public function render()
    {
        return view('livewire.users.show');
    }
}