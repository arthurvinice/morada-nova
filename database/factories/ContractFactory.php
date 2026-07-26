<?php

namespace Database\Factories;

use App\Models\Configuration;
use App\Models\People;
use App\Models\Property;
use App\Models\User;
use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'start_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'end_date' => null,
            'payday' => $this->faker->numberBetween(1, 28),
            'rent_value' => $this->faker->randomFloat(2, 700, 3500),
            'status' => 'active',
            'file' => null,
            'property_id' => Property::factory(),
            'people_id' => People::factory(),
            'user_id' => User::factory(),
            'configuration_id' => Configuration::factory(),
        ];
    }
}