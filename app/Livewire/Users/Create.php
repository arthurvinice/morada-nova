<?php

namespace App\Livewire\Users;

use App\Models\Configuration;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $cpf = '';
    public $email = '';
    public $phone = '';
    public $role = 'standard';
    public $status = 'active';
    public $password = '';
    public $configuration_id = null;

    public function mount()
    {
        abort_unless(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin(), 403);
    }

    protected function rules(): array
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'cpf'      => 'required|string|max:14|unique:users,cpf',
            'email'    => 'required|email|max:255|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'role'     => 'required|in:standard,admin',
            'status'   => 'required|in:active,inactive',
            'password' => 'required|string|min:8',
        ];

        if (auth()->user()->isSuperAdmin()) {
            $rules['configuration_id'] = $this->role === 'standard'
                ? 'required|exists:configurations,id'
                : 'nullable|exists:configurations,id';
        }

        return $rules;
    }

    protected $messages = [
        'name.required'             => 'O nome é obrigatório.',
        'cpf.required'               => 'O CPF é obrigatório.',
        'cpf.unique'                 => 'Este CPF já está cadastrado.',
        'email.required'             => 'O e-mail é obrigatório.',
        'email.unique'               => 'Este e-mail já está cadastrado.',
        'password.required'          => 'A senha é obrigatória.',
        'password.min'               => 'A senha deve ter no mínimo 8 caracteres.',
        'configuration_id.required'  => 'Selecione a configuração para usuários padrão.',
        'configuration_id.exists'    => 'Configuração inválida.',
    ];

    public function save()
    {
        $this->validate();

        $configurationId = null;

        if (auth()->user()->isSuperAdmin()) {
            if ($this->role === 'admin' && ! $this->configuration_id) {
                $configuration = Configuration::create([
                    'uuid'   => (string) Str::uuid(),
                    'name'   => $this->name,
                    'status' => $this->status,
                ]);

                $configurationId = $configuration->id;
            } else {
                $configurationId = $this->configuration_id;
            }
        }

        User::create([
            'uuid'             => (string) Str::uuid(),
            'name'             => $this->name,
            'cpf'              => $this->cpf,
            'email'            => $this->email,
            'phone'            => $this->phone,
            'role'             => $this->role,
            'status'           => $this->status,
            'password'         => Hash::make($this->password),
            'configuration_id' => $configurationId,
        ]);

        session()->flash('success', 'Usuário criado com sucesso!');

        return redirect()->route('admin.user.index');
    }

    public function render()
    {
        return view('livewire.users.create', [
            'configurations' => auth()->user()->isSuperAdmin()
                ? Configuration::orderBy('name')->get()
                : collect(),
        ]);
    }
}