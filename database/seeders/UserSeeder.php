<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('123456'),
            'nivel' => 'SuperAdmin',
            'is_ativo' => true,
            'departamento_id' => Arr::random([1,2]),
        ]);

    }
}
