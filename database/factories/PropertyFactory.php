<?php

namespace Database\Factories;

use App\Models\Configuration;
use App\Models\PropertyType;
use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $cidades = [
            ['city' => 'Natal', 'state' => 'RN'],
            ['city' => 'Mossoró', 'state' => 'RN'],
            ['city' => 'João Pessoa', 'state' => 'PB'],
            ['city' => 'Fortaleza', 'state' => 'CE'],
        ];

        $local = $this->faker->randomElement($cidades);

        return [
            'uuid' => Str::uuid(),
            'nickname' => $this->faker->streetName() . ' - ' . $this->faker->buildingNumber(),
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'city' => $local['city'],
            'state' => $local['state'],
            'zip_code' => $this->faker->numerify('#####-###'),
            'complement' => $this->faker->optional()->secondaryAddress(),
            'description' => $this->faker->optional()->sentence(),
            'rent_value' => $this->faker->randomFloat(2, 700, 3500),
            'status' => 'available',
            'user_id' => User::factory(),
            'property_type_id' => PropertyType::inRandomOrder()->first()?->id
                ?? PropertyType::factory(),
            'configuration_id' => Configuration::factory(),
        ];
    }
}
