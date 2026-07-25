<?php

namespace Database\Seeders;

use App\Models\ChangelogCategory;
use App\Models\Configuration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'uuid' => Str::uuid(),
            'name' => 'Arthur Vinícius',
            'role' => 'superadmin',
            'status' => 'active',
            'email' => 'arthurvinice@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $configuration = Configuration::create([
            'uuid' => Str::uuid(),
            'name' => 'Imobiliária Teste',
            'status' => 'active',
        ]);

        User::factory()->create([
            'uuid' => Str::uuid(),
            'configuration_id' => $configuration->id,
            'name' => 'Administrador teste',
            'role' => 'admin',
            'status' => 'active',
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

        $this->call([
            PropertyTypeSeeder::class,
            PeopleSeeder::class,
            PropertySeeder::class,
            ContractSeeder::class,
        ]);
    }
}