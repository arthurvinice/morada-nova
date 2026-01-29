<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ChangelogCategory;
use App\Models\Department;
use App\Models\Subcategory;
use App\Models\User;
use App\Models\People;
use App\Models\Order;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
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

        Department::factory()->create([
            'nome' => 'Loja 1',
            'cnpj' => '12345678901234',
            // 'logo' => url('assets/img/logo-hospital.png'),
            'email' => 'loja1@housecriative.com.br',
            'telefone_principal' => '(11) 99999-9999',
        ]);

        Department::factory()->create([
            'nome' => 'Loja 2',
            'cnpj' => '98765432109876',
            // 'logo' => url('assets/img/logo-infra.png'),
            'email' => 'loja2@housecriative.com.br',
            'telefone_principal' => '(11) 88888-8888',
        ]);

        // Department::factory()->create([
        //     'nome' => 'Secretaria de Educação',
        //     'cnpj' => '12345678901235',
        //     'logo' => url('assets/img/logo-edu.png'),
        //     'email' => 'educacao@housecriative.com.br',
        //     'telefone_principal' => '(11) 77777-7777',
        // ]);


        User::factory()->create([
            'name' => 'Roberto Ferreira',
            'nivel' => 'SuperAdmin',
            'is_ativo' => true,
            'email' => 'roberto@housecriative.com.br',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'departamento_id' => null,
        ]);

        User::factory()->create([
            'name' => 'Ferreira Júnior',
            'nivel' => 'SuperAdmin',
            'is_ativo' => true,
            'email' => 'paulojunior@housecriative.com.br',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'departamento_id' => null,
        ]);

        User::factory()->create([
            'name' => 'Arthur Vinícius',
            'nivel' => 'SuperAdmin',
            'is_ativo' => true,
            'email' => 'arthurvinice@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'departamento_id' => null,
        ]);

        ChangelogCategory::factory()->createMany([
            ['nome' => 'Correção de Bug'],
            ['nome' => 'Nova Funcionalidade'],
            ['nome' => 'Melhoria de Performance'],
            ['nome' => 'Atualização de Segurança'],
            ['nome' => 'Mudança na Interface'],
        ]);



        // // LOJA 1

        // User::factory()->create([
        //     'name' => 'Ilana Martins',
        //     'nivel' => 'Administrador',
        //     'is_ativo' => true,
        //     'departamento_id' => '1',
        //     'email' => 'adm-loja1@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => static::$password ??= Hash::make('password'),
        //     'remember_token' => Str::random(10),
        // ]);

        // // LOJA 2

        // User::factory()->create([
        //     'name' => 'Josias Albuquerque',
        //     'nivel' => 'Administrador',
        //     'is_ativo' => true,
        //     'departamento_id' => 2,
        //     'email' => 'adm-loja2@gmail.com',
        //     'email_verified_at' => now(),
        //     'password' => static::$password ??= Hash::make('password'),
        //     'remember_token' => Str::random(10),
        // ]);
    }
}
