<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('property_types')->insert([
            ['name' => 'Apartamento', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Casa', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Comercial', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kitnet', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}