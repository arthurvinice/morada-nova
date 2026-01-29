<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChangelogCategory>
 */
class ChangelogCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->randomElement([
                'Correção de Bug',
                'Nova Funcionalidade',
                'Melhoria de Performance',
                'Atualização de Segurança',
                'Mudança na Interface',
            ])
        ];
    }
}
