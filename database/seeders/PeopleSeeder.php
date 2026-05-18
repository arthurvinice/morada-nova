<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeopleSeeder extends Seeder
{
    public function run(): void
    {
        $userId = DB::table('users')->where('role', 'Administrador')->value('id');

        $people = [
            [
                'name'       => 'Carlos Pereira',
                'cpf'        => '333.333.333-33',
                'phone'      => '(84) 98111-3333',
                'email'      => 'carlos.pereira@email.com',
                'document'   => null,
                'user_id'    => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Fernanda Lima',
                'cpf'        => '444.444.444-44',
                'phone'      => '(84) 99222-4444',
                'email'      => 'fernanda.lima@email.com',
                'document'   => null,
                'user_id'    => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Ricardo Alves',
                'cpf'        => '555.555.555-55',
                'phone'      => '(84) 99333-5555',
                'email'      => null,
                'document'   => null,
                'user_id'    => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('people')->insert($people);
    }
}