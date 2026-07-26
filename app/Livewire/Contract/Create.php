<?php

namespace App\Livewire\Contract;

use App\Models\Contract;
use App\Models\People;
use App\Models\Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $start_date;
    public $end_date;
    public $payday = 1;
    public $rent_value;
    public $status = 'active';
    public $property_id;
    public $people_id;
    public $file;

    protected $rules = [
        'start_date'  => 'required|date',
        'end_date'    => 'nullable|date|after:start_date',
        'payday'      => 'required|integer|min:1|max:31',
        'rent_value'  => 'required|numeric|min:0',
        'status'      => 'required|string|in:active,finished,cancelled',
        'property_id' => 'required|exists:properties,id',
        'people_id'   => 'required|exists:people,id',
        'file'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
    ];

    protected $messages = [
        'start_date.required'  => 'A data de início é obrigatória.',
        'end_date.after'       => 'A data de término deve ser posterior à data de início.',
        'rent_value.required'  => 'O valor do aluguel é obrigatório.',
        'rent_value.numeric'   => 'Informe um valor de aluguel válido.',
        'property_id.required' => 'Selecione o imóvel.',
        'property_id.exists'   => 'Imóvel inválido.',
        'people_id.required'   => 'Selecione o inquilino.',
        'people_id.exists'     => 'Inquilino inválido.',
        'file.mimes'           => 'O arquivo deve ser PDF, JPG ou PNG.',
        'file.max'             => 'O arquivo não pode ultrapassar 5MB.',
    ];

    public function updatedPropertyId($value)
    {
        $property = Property::find($value);

        if ($property) {
            $this->rent_value = $property->rent_value;
        }
    }

    public function store()
    {
        $this->validate();

        $filePath = null;

        DB::beginTransaction();

        try {
            if ($this->file) {
                $filePath = $this->file->store('contracts_files', 'public');
            }

            Contract::create([
                'start_date'  => $this->start_date,
                'end_date'    => $this->end_date,
                'payday'      => $this->payday,
                'rent_value'  => $this->rent_value,
                'status'      => $this->status,
                'file'        => $filePath,
                'property_id' => $this->property_id,
                'people_id'   => $this->people_id,
                'user_id'     => auth()->id(),
            ]);

            if ($this->status === 'active') {
                Property::find($this->property_id)->update(['status' => 'rented']);
            }

            DB::commit();

            session()->flash('success', 'Contrato cadastrado com sucesso!');

            return redirect()->route('admin.contracts.index');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }

            session()->flash('error', 'Erro ao cadastrar contrato: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.contract.create', [
            'properties' => Property::where('status', 'available')->orderBy('street')->get(),
            'people'     => People::orderBy('name')->get(),
        ]);
    }
}