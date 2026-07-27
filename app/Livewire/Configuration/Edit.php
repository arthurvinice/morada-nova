<?php

namespace App\Livewire\Configuration;

use App\Models\Configuration;
use Livewire\Component;

class Edit extends Component
{
    public Configuration $configuration;

    public $name = '';
    public $status = '';

    protected $rules = [
        'name'   => 'required|string|max:255',
        'status' => 'required|in:active,inactive',
    ];

    protected $messages = [
        'name.required' => 'O nome é obrigatório.',
    ];

    public function mount(Configuration $configuration)
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);

        $this->configuration = $configuration;
        $this->name = $configuration->name;
        $this->status = $configuration->status;
    }

    public function update()
    {
        $this->validate();

        $this->configuration->update([
            'name'   => $this->name,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Configuração atualizada com sucesso!');

        return redirect()->route('admin.configurations.index');
    }

    public function render()
    {
        return view('livewire.configuration.edit', [
            'usersCount' => $this->configuration->users()->count(),
            'propertiesCount' => $this->configuration->properties()->count(),
        ]);
    }
}