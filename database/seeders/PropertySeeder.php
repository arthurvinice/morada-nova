<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $userId     = DB::table('users')->where('role', 'Administrador')->value('id');
        $buildingId = DB::table('buildings')->value('id');

        $properties = [
            [
                'type'        => 'apartment',
                'street'      => 'Av. Engenheiro Roberto Freire',
                'number'      => '1500 - Apto 101',
                'city'        => 'Natal',
                'state'       => 'RN',
                'zip_code'    => '59082-902',
                'rent_value'  => 1200.00,
                'status'      => 'rented',
                'building_id' => $buildingId,
                'user_id'     => $userId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'type'        => 'apartment',
                'street'      => 'Av. Engenheiro Roberto Freire',
                'number'      => '1500 - Apto 202',
                'city'        => 'Natal',
                'state'       => 'RN',
                'zip_code'    => '59082-902',
                'rent_value'  => 1350.00,
                'status'      => 'available',
                'building_id' => $buildingId,
                'user_id'     => $userId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'type'        => 'house',
                'street'      => 'Rua Coronel Flamínio',
                'number'      => '75',
                'city'        => 'Natal',
                'state'       => 'RN',
                'zip_code'    => '59020-010',
                'rent_value'  => 2500.00,
                'status'      => 'available',
                'building_id' => null,
                'user_id'     => $userId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'type'        => 'commercial',
                'street'      => 'Av. Prudente de Morais',
                'number'      => '850',
                'city'        => 'Natal',
                'state'       => 'RN',
                'zip_code'    => '59020-400',
                'rent_value'  => 3800.00,
                'status'      => 'rented',
                'building_id' => null,
                'user_id'     => $userId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        DB::table('properties')->insert($properties);
    }
}