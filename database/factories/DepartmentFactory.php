<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->company(),
            'logo' => $this->faker->optional()->imageUrl(640, 480, 'business'),
            'email' => $this->faker->optional()->companyEmail(),
            'telefone_principal' => $this->faker->optional()->phoneNumber(),
            'telefone_secundario' => $this->faker->optional()->phoneNumber(),
            'rua' => $this->faker->optional()->streetName(),
            'numero' => $this->faker->optional()->buildingNumber(),
            'bairro' => $this->faker->optional()->word(),
            'cidade' => $this->faker->optional()->city(),
            'cep' => $this->faker->optional()->postcode(),
            'uf' => $this->faker->optional()->stateAbbr(),
            'complemento' => $this->faker->optional()->secondaryAddress(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
