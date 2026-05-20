<?php

namespace App\Livewire\People;

use App\Models\People;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $cpf;
    public $phone;
    public $email;
    public $document;

    protected $rules = [
        'name'     => 'required|string|max:255',
        'cpf'      => 'required|string|max:14|unique:people,cpf',
        'phone'    => 'required|string|max:20',
        'email'    => 'nullable|email|max:255',
        'document' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'name.required'  => 'O nome é obrigatório.',
        'cpf.required'   => 'O CPF é obrigatório.',
        'cpf.unique'     => 'Este CPF já está cadastrado.',
        'phone.required' => 'O telefone é obrigatório.',
        'email.email'    => 'Informe um e-mail válido.',
    ];

    public function store()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            People::create([
                'name'     => $this->name,
                'cpf'      => $this->cpf,
                'phone'    => $this->phone,
                'email'    => $this->email,
                'document' => $this->document,
                'user_id'  => auth()->id(),
            ]);

            DB::commit();

            session()->flash('success', 'Inquilino cadastrado com sucesso!');

            return redirect()->route('admin.people.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao cadastrar inquilino: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.people.create');
    }
}