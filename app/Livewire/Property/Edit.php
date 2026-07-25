<?php

namespace App\Livewire\Property;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public Property $property;

    public $nickname;
    public $street;
    public $number;
    public $city;
    public $state;
    public $zip_code;
    public $complement;
    public $description;
    public $rent_value;
    public $status;
    public $property_type_id;

    protected $rules = [
        'nickname'          => 'nullable|string|max:255',
        'street'            => 'required|string|max:255',
        'number'            => 'required|string|max:20',
        'city'              => 'required|string|max:255',
        'state'             => 'required|string|max:2',
        'zip_code'          => 'required|string|max:10',
        'complement'        => 'nullable|string|max:255',
        'description'       => 'nullable|string',
        'rent_value'        => 'nullable|numeric|min:0',
        'status'            => 'required|string|in:available,rented,maintenance',
        'property_type_id'  => 'required|exists:property_types,id',
    ];

    protected $messages = [
        'street.required'           => 'A rua é obrigatória.',
        'number.required'           => 'O número é obrigatório.',
        'city.required'              => 'A cidade é obrigatória.',
        'state.required'            => 'O estado é obrigatório.',
        'zip_code.required'         => 'O CEP é obrigatório.',
        'rent_value.numeric'        => 'Informe um valor de aluguel válido.',
        'property_type_id.required' => 'Selecione o tipo do imóvel.',
        'property_type_id.exists'   => 'Tipo de imóvel inválido.',
    ];

    public function mount(Property $property)
    {
        abort_if(
            auth()->user()->role !== 'SuperAdmin' && $property->user_id !== auth()->id(),
            403,
            'Você não tem permissão para editar esta propriedade.'
        );

        $this->property = $property;
        $this->nickname = $property->nickname;
        $this->street = $property->street;
        $this->number = $property->number;
        $this->city = $property->city;
        $this->state = $property->state;
        $this->zip_code = $property->zip_code;
        $this->complement = $property->complement;
        $this->description = $property->description;
        $this->rent_value = $property->rent_value;
        $this->status = $property->status;
        $this->property_type_id = $property->property_type_id;
    }

    public function update()
    {
        abort_if(
            auth()->user()->role !== 'SuperAdmin' && $this->property->user_id !== auth()->id(),
            403,
            'Você não tem permissão para editar esta propriedade.'
        );

        $this->validate();

        DB::beginTransaction();

        try {
            $this->property->update([
                'nickname'          => $this->nickname,
                'street'            => $this->street,
                'number'            => $this->number,
                'city'              => $this->city,
                'state'             => $this->state,
                'zip_code'          => $this->zip_code,
                'complement'        => $this->complement,
                'description'       => $this->description,
                'rent_value'        => $this->rent_value,
                'status'            => $this->status,
                'property_type_id'  => $this->property_type_id,
            ]);

            DB::commit();

            session()->flash('success', 'Propriedade atualizada com sucesso!');

            return redirect()->route('admin.properties.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao atualizar propriedade: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.property.edit', [
            'propertyTypes' => PropertyType::orderBy('name')->get(),
        ]);
    }
}