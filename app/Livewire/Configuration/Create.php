<?php

namespace App\Livewire\Configuration;

use App\Models\Configuration;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $status = 'active';

    protected $rules = [
        'name'   => 'required|string|max:255',
        'status' => 'required|in:active,inactive',
    ];

    protected $messages = [
        'name.required' => 'O nome é obrigatório.',
    ];

    public function mount()
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);
    }

    public function save()
    {
        $this->validate();

        Configuration::create([
            'uuid'   => (string) Str::uuid(),
            'name'   => $this->name,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Configuração criada com sucesso!');

        return redirect()->route('admin.configurations.index');
    }

    public function render()
    {
        return view('livewire.configuration.create');
    }
}