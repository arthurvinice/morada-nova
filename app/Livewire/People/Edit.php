<?php

namespace App\Livewire\People;

use App\Models\People;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public People $person;

    public $name;
    public $cpf;
    public $phone;
    public $email;
    public $document;

    protected function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'cpf'      => 'required|string|max:14|unique:people,cpf,' . $this->person->id,
            'phone'    => 'required|string|max:20',
            'email'    => 'nullable|email|max:255',
            'document' => 'nullable|string|max:255',
        ];
    }

    protected $messages = [
        'name.required'  => 'O nome é obrigatório.',
        'cpf.required'   => 'O CPF é obrigatório.',
        'cpf.unique'     => 'Este CPF já está cadastrado.',
        'phone.required' => 'O telefone é obrigatório.',
        'email.email'    => 'Informe um e-mail válido.',
    ];

    public function mount(People $person)
    {
        $this->person   = $person;
        $this->name     = $person->name;
        $this->cpf      = $person->cpf;
        $this->phone    = $person->phone;
        $this->email    = $person->email;
        $this->document = $person->document;
    }

    public function update()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            $this->person->update([
                'name'     => $this->name,
                'cpf'      => $this->cpf,
                'phone'    => $this->phone,
                'email'    => $this->email,
                'document' => $this->document,
            ]);

            DB::commit();

            session()->flash('success', 'Inquilino atualizado com sucesso!');

            return redirect()->route('admin.people.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao atualizar inquilino: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.people.edit');
    }
}