<?php

namespace App\Livewire\People;

use App\Models\People;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

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
        'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
    ];

    protected $messages = [
        'name.required'   => 'O nome é obrigatório.',
        'cpf.required'    => 'O CPF é obrigatório.',
        'cpf.unique'      => 'Este CPF já está cadastrado.',
        'phone.required'  => 'O telefone é obrigatório.',
        'email.email'     => 'Informe um e-mail válido.',
        'document.mimes'  => 'O documento deve ser PDF, JPG ou PNG.',
        'document.max'    => 'O documento não pode ultrapassar 5MB.',
    ];

    public function store()
    {
        $this->validate();

        $documentPath = null;

        DB::beginTransaction();

        try {
            if ($this->document) {
                $documentPath = $this->document->store('people_documents', 'public');
            }

            People::create([
                'name'     => $this->name,
                'cpf'      => $this->cpf,
                'phone'    => $this->phone,
                'email'    => $this->email,
                'document' => $documentPath,
                'user_id'  => auth()->id(),
            ]);

            DB::commit();

            session()->flash('success', 'Inquilino cadastrado com sucesso!');

            return redirect()->route('admin.people.index');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($documentPath) {
                Storage::disk('public')->delete($documentPath);
            }

            session()->flash('error', 'Erro ao cadastrar inquilino: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.people.create');
    }
}