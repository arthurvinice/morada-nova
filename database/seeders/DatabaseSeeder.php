<?php

namespace Database\Seeders;

use App\Models\ChangelogCategory;
use App\Models\User;
use App\Models\Terms;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    protected static ?string $password;


    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'uuid' => Str::uuid(),
            'name' => 'Arthur Vinícius',
            'role' => 'SuperAdmin',
            'is_ativo' => true,
            'email' => 'arthurvinice@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        User::factory()->create([
           'uuid' => Str::uuid(),
           'name' => 'Administrador teste',
           'role' => 'Administrador',
           'is_ativo' => true,
           'email' => 'admin@teste.com',
           'email_verified_at' => now(),
           'password' => Hash::make('password'),
           'remember_token' => Str::random(10),
        ]);

        ChangelogCategory::factory()->createMany([
            ['nome' => 'Correção de Bug'],
            ['nome' => 'Nova Funcionalidade'],
            ['nome' => 'Melhoria de Performance'],
            ['nome' => 'Atualização de Segurança'],
            ['nome' => 'Mudança na Interface'],
        ]);

    }
}
