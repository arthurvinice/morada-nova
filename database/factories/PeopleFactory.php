<?php

namespace Database\Factories;

use App\Models\Configuration;
use App\Models\User;
use App\Models\People;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PeopleFactory extends Factory
{
    protected $model = People::class;

    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->name(),
            'cpf' => $this->faker->unique()->numerify('###.###.###-##'),
            'phone' => $this->faker->numerify('(##) 9####-####'),
            'email' => $this->faker->optional()->safeEmail(),
            'document' => null,
            'user_id' => User::factory(),
            'configuration_id' => Configuration::factory(),
        ];
    }
}