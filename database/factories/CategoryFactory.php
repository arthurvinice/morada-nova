<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorias = [
            'Transferência','Saúde', 'Educação', 'Segurança', 'Transporte', 'Meio Ambiente',
            'Cultura', 'Esporte', 'Lazer', 'Assistência Social', 'Habitação',
            'Urbanismo', 'Agricultura', 'Indústria', 'Comércio', 'Turismo',
            'Ciência e Tecnologia', 'Comunicação', 'Direitos Humanos', 'Justiça', 'Trabalho'
        ];

        return [
            'titulo' => $this->faker->unique()->randomElement($categorias),
            'departamento_id' => Department::factory(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
