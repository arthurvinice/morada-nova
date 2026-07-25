<?php

namespace App\Livewire\Property;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Create extends Component
{
    public $zip_code;
    public $street;
    public $number;
    public $complement;
    public $city;
    public $state;
    public $nickname;
    public $description;
    public $rent_value;
    public $status = 'available';
    public $property_type_id;

    protected $rules = [
        'nickname'          => 'nullable|string|max:255',
        'zip_code'          => 'required|string|max:10',
        'street'            => 'required|string|max:255',
        'number'            => 'required|string|max:20',
        'complement'        => 'nullable|string|max:255',
        'city'              => 'required|string|max:255',
        'state'             => 'required|string|max:2',
        'description'       => 'nullable|string',
        'rent_value'        => 'nullable|numeric|min:0',
        'status'            => 'required|string|in:available,rented,maintenance',
        'property_type_id'  => 'required|exists:property_types,id',
    ];

    protected $messages = [
        'zip_code.required'         => 'O CEP é obrigatório.',
        'street.required'           => 'A rua é obrigatória.',
        'number.required'           => 'O número é obrigatório.',
        'city.required'             => 'A cidade é obrigatória.',
        'state.required'            => 'O estado é obrigatório.',
        'rent_value.numeric'        => 'Informe um valor de aluguel válido.',
        'property_type_id.required' => 'Selecione o tipo do imóvel.',
        'property_type_id.exists'   => 'Tipo de imóvel inválido.',
    ];

    public function buscarCep()
    {
        $cepLimpo = preg_replace('/\D/', '', $this->zip_code ?? '');

        if (strlen($cepLimpo) !== 8) {
            return;
        }

        try {
            $response = Http::timeout(5)->get("https://viacep.com.br/ws/{$cepLimpo}/json/");

            if ($response->failed()) {
                session()->flash('error', 'Erro ao consultar o CEP.');
                return;
            }

            $data = $response->json();

            if (isset($data['erro'])) {
                session()->flash('error', 'CEP não encontrado.');
                $this->reset(['street', 'city', 'state']);
                return;
            }

            $this->street = $data['logradouro'] ?? '';
            $this->city = $data['localidade'] ?? '';
            $this->state = $data['uf'] ?? '';

            if (!empty($data['complemento']) && empty($this->complement)) {
                $this->complement = $data['complemento'];
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao buscar CEP.');
        }
    }

    public function store()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            Property::create([
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
                'user_id'           => auth()->id(),
                'property_type_id'  => $this->property_type_id,
            ]);

            DB::commit();

            session()->flash('success', 'Propriedade cadastrada com sucesso!');

            return redirect()->route('admin.properties.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao cadastrar propriedade: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.property.create', [
            'propertyTypes' => PropertyType::orderBy('name')->get(),
        ]);
    }
}