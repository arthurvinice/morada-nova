<?php

namespace Database\Factories;

use App\Models\Configuration;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->name(),
            'cpf' => $this->faker->unique()->numerify('###.###.###-##'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('(##) 9####-####'),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'standard',
            'status' => 'active',
            'configuration_id' => Configuration::factory(),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => ['role' => 'admin']);
    }

    public function superadmin(): static
    {
        return $this->state(fn () => ['role' => 'superadmin', 'configuration_id' => null]);
    }
}