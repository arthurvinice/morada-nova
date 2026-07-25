<?php

namespace App\Livewire\Public;

use App\Models\Configuration;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateUser extends Component
{
    #[Rule('required|string|max:255')]
    public string $companyName = '';

    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|string|max:14|unique:users,cpf')]
    public string $cpf = '';

    #[Rule('required|email|max:255|unique:users,email')]
    public string $email = '';

    #[Rule('required|string|min:8')]
    public string $password = '';

    public function register()
    {
        $this->validate();

        DB::transaction(function () {
            $configuration = Configuration::create([
                'uuid' => (string) Str::uuid(),
                'name' => $this->companyName,
                'status' => 'active',
            ]);

            User::create([
                'uuid' => (string) Str::uuid(),
                'configuration_id' => $configuration->id,
                'name' => $this->name,
                'cpf' => $this->cpf,
                'email' => $this->email,
                'role' => 'admin',
                'status' => 'active',
                'password' => Hash::make($this->password),
            ]);
        });

        session()->flash('success', 'Cadastro realizado com sucesso!');

        return redirect()->route('login');
    }
    public function render()
    {
        return view('livewire.public.create-user');
    }
}
