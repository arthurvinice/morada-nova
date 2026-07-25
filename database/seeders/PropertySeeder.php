<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        $admin = DB::table('users')->where('email', 'admin@teste.com')->first();
        $typeIds = PropertyType::pluck('id', 'name');

        $properties = [
            ['nickname' => 'Apto 101 - Ed. Solar', 'street' => 'Rua das Rosas', 'number' => '101', 'city' => 'Natal', 'state' => 'RN', 'zip_code' => '59000-000', 'rent_value' => 1200.00, 'type' => 'Apartamento'],
            ['nickname' => 'Casa Ponta Negra', 'street' => 'Av. Engenheiro Roberto Freire', 'number' => '2000', 'city' => 'Natal', 'state' => 'RN', 'zip_code' => '59090-000', 'rent_value' => 2500.00, 'type' => 'Casa'],
            ['nickname' => 'Loja Centro', 'street' => 'Av. Rio Branco', 'number' => '500', 'city' => 'Natal', 'state' => 'RN', 'zip_code' => '59025-000', 'rent_value' => 1800.00, 'type' => 'Comercial'],
            ['nickname' => 'Kitnet Lagoa Nova', 'street' => 'Rua Jaguarari', 'number' => '150', 'city' => 'Natal', 'state' => 'RN', 'zip_code' => '59064-000', 'rent_value' => 800.00, 'type' => 'Kitnet'],
            ['nickname' => 'Apto 202 - Ed. Marina', 'street' => 'Av. Praia de Ponta Negra', 'number' => '850', 'city' => 'Natal', 'state' => 'RN', 'zip_code' => '59090-050', 'rent_value' => 1600.00, 'type' => 'Apartamento'],
            ['nickname' => 'Apto 305 - Ed. Bela Vista', 'street' => 'Rua Potengi', 'number' => '340', 'city' => 'Natal', 'state' => 'RN', 'zip_code' => '59014-100', 'rent_value' => 1350.00, 'type' => 'Apartamento'],
            ['nickname' => 'Casa Neópolis', 'street' => 'Rua Vale do Ivaí', 'number' => '75', 'city' => 'Natal', 'state' => 'RN', 'zip_code' => '59078-400', 'rent_value' => 2100.00, 'type' => 'Casa'],
            ['nickname' => 'Casa Candelária', 'street' => 'Rua Amaro Barreto', 'number' => '410', 'city' => 'Natal', 'state' => 'RN', 'zip_code' => '59064-660', 'rent_value' => 1950.00, 'type' => 'Casa'],
            ['nickname' => 'Sala Comercial Petrópolis', 'street' => 'Av. Hermes da Fonseca', 'number' => '980', 'city' => 'Natal', 'state' => 'RN', 'zip_code' => '59020-650', 'rent_value' => 2200.00, 'type' => 'Comercial'],
            ['nickname' => 'Ponto Comercial Alecrim', 'street' => 'Av. Coronel Estevam', 'number' => '1220', 'city' => 'Natal', 'state' => 'RN', 'zip_code' => '59031-350', 'rent_value' => 1700.00, 'type' => 'Comercial'],
            ['nickname' => 'Kitnet Capim Macio', 'street' => 'Rua Vereda Tropical', 'number' => '60', 'city' => 'Natal', 'state' => 'RN', 'zip_code' => '59078-970', 'rent_value' => 750.00, 'type' => 'Kitnet'],
            ['nickname' => 'Kitnet Tirol', 'street' => 'Rua Apodi', 'number' => '210', 'city' => 'Natal', 'state' => 'RN', 'zip_code' => '59020-390', 'rent_value' => 900.00, 'type' => 'Kitnet'],
        ];

        foreach ($properties as $property) {
            Property::create([
                'nickname' => $property['nickname'],
                'street' => $property['street'],
                'number' => $property['number'],
                'city' => $property['city'],
                'state' => $property['state'],
                'zip_code' => $property['zip_code'],
                'rent_value' => $property['rent_value'],
                'status' => 'available',
                'user_id' => $admin->id,
                'configuration_id' => $admin->configuration_id,
                'property_type_id' => $typeIds[$property['type']],
            ]);
        }
    }
}