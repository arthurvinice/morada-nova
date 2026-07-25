<?php

namespace App\Livewire\People;

use App\Models\People;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public People $people;

    public $name;
    public $cpf;
    public $phone;
    public $email;
    public $document;

    protected $messages = [
        'name.required'   => 'O nome é obrigatório.',
        'cpf.required'    => 'O CPF é obrigatório.',
        'cpf.unique'      => 'Este CPF já está cadastrado.',
        'phone.required'  => 'O telefone é obrigatório.',
        'email.email'     => 'Informe um e-mail válido.',
        'document.mimes'  => 'O documento deve ser PDF, JPG ou PNG.',
        'document.max'    => 'O documento não pode ultrapassar 5MB.',
    ];

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'cpf'      => 'required|string|max:14|unique:people,cpf,' . $this->people->id,
            'phone'    => 'required|string|max:20',
            'email'    => 'nullable|email|max:255',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function mount(People $people)
    {
        $this->people = $people;
        $this->name = $people->name;
        $this->cpf = $people->cpf;
        $this->phone = $people->phone;
        $this->email = $people->email;
    }

    public function update()
    {
        $this->validate();

        $documentPath = $this->people->document;

        DB::beginTransaction();

        try {
            if ($this->document) {
                if ($this->people->document) {
                    Storage::disk('public')->delete($this->people->document);
                }

                $documentPath = $this->document->store('people_documents', 'public');
            }

            $this->people->update([
                'name'     => $this->name,
                'cpf'      => $this->cpf,
                'phone'    => $this->phone,
                'email'    => $this->email,
                'document' => $documentPath,
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