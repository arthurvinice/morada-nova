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
            // Natal - RN
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

            // Mossoró - RN
            ['nickname' => 'Casa Alto de São Manoel', 'street' => 'Rua Coronel Machado', 'number' => '320', 'city' => 'Mossoró', 'state' => 'RN', 'zip_code' => '59600-000', 'rent_value' => 1400.00, 'type' => 'Casa'],
            ['nickname' => 'Apto Centro Mossoró', 'street' => 'Av. Rio Branco', 'number' => '90', 'city' => 'Mossoró', 'state' => 'RN', 'zip_code' => '59610-100', 'rent_value' => 1100.00, 'type' => 'Apartamento'],
            ['nickname' => 'Loja Nova Betânia', 'street' => 'Av. Presidente Dutra', 'number' => '640', 'city' => 'Mossoró', 'state' => 'RN', 'zip_code' => '59628-000', 'rent_value' => 1600.00, 'type' => 'Comercial'],

            // Parnamirim - RN
            ['nickname' => 'Casa Nova Parnamirim', 'street' => 'Rua Piaçava', 'number' => '55', 'city' => 'Parnamirim', 'state' => 'RN', 'zip_code' => '59151-000', 'rent_value' => 1750.00, 'type' => 'Casa'],
            ['nickname' => 'Apto Cohabinal', 'street' => 'Rua Marechal Rondon', 'number' => '410', 'city' => 'Parnamirim', 'state' => 'RN', 'zip_code' => '59140-000', 'rent_value' => 1250.00, 'type' => 'Apartamento'],

            // João Pessoa - PB
            ['nickname' => 'Apto Manaíra', 'street' => 'Av. General Edson Ramalho', 'number' => '450', 'city' => 'João Pessoa', 'state' => 'PB', 'zip_code' => '58038-000', 'rent_value' => 1900.00, 'type' => 'Apartamento'],
            ['nickname' => 'Casa Bessa', 'street' => 'Rua Belarmino Freire', 'number' => '210', 'city' => 'João Pessoa', 'state' => 'PB', 'zip_code' => '58033-000', 'rent_value' => 2300.00, 'type' => 'Casa'],
            ['nickname' => 'Loja Epitácio Pessoa', 'street' => 'Av. Epitácio Pessoa', 'number' => '1300', 'city' => 'João Pessoa', 'state' => 'PB', 'zip_code' => '58030-000', 'rent_value' => 2000.00, 'type' => 'Comercial'],
            ['nickname' => 'Kitnet Tambaú', 'street' => 'Av. Almirante Tamandaré', 'number' => '80', 'city' => 'João Pessoa', 'state' => 'PB', 'zip_code' => '58039-000', 'rent_value' => 950.00, 'type' => 'Kitnet'],

            // Campina Grande - PB
            ['nickname' => 'Apto Prata', 'street' => 'Rua Miguel Couto', 'number' => '175', 'city' => 'Campina Grande', 'state' => 'PB', 'zip_code' => '58400-000', 'rent_value' => 1150.00, 'type' => 'Apartamento'],
            ['nickname' => 'Casa Catolé', 'street' => 'Rua José Florentino', 'number' => '380', 'city' => 'Campina Grande', 'state' => 'PB', 'zip_code' => '58410-000', 'rent_value' => 1500.00, 'type' => 'Casa'],

            // Fortaleza - CE
            ['nickname' => 'Apto Aldeota', 'street' => 'Av. Dom Luís', 'number' => '900', 'city' => 'Fortaleza', 'state' => 'CE', 'zip_code' => '60160-000', 'rent_value' => 2600.00, 'type' => 'Apartamento'],
            ['nickname' => 'Casa Meireles', 'street' => 'Rua Ildefonso Albano', 'number' => '600', 'city' => 'Fortaleza', 'state' => 'CE', 'zip_code' => '60115-000', 'rent_value' => 3200.00, 'type' => 'Casa'],
            ['nickname' => 'Loja Centro Fortaleza', 'street' => 'Rua Major Facundo', 'number' => '220', 'city' => 'Fortaleza', 'state' => 'CE', 'zip_code' => '60025-000', 'rent_value' => 2400.00, 'type' => 'Comercial'],
            ['nickname' => 'Kitnet Benfica', 'street' => 'Rua Pereira Filgueiras', 'number' => '45', 'city' => 'Fortaleza', 'state' => 'CE', 'zip_code' => '60020-000', 'rent_value' => 1000.00, 'type' => 'Kitnet'],
            ['nickname' => 'Apto Papicu', 'street' => 'Av. Engenheiro Santana Júnior', 'number' => '310', 'city' => 'Fortaleza', 'state' => 'CE', 'zip_code' => '60175-000', 'rent_value' => 1850.00, 'type' => 'Apartamento'],

            // Sobral - CE
            ['nickname' => 'Casa Centro Sobral', 'street' => 'Rua Coronel José Adejalmo', 'number' => '130', 'city' => 'Sobral', 'state' => 'CE', 'zip_code' => '62010-000', 'rent_value' => 1300.00, 'type' => 'Casa'],
            ['nickname' => 'Apto Junco', 'street' => 'Rua Dom José', 'number' => '260', 'city' => 'Sobral', 'state' => 'CE', 'zip_code' => '62030-000', 'rent_value' => 1050.00, 'type' => 'Apartamento'],

            // Juazeiro do Norte - CE
            ['nickname' => 'Loja Padre Cícero', 'street' => 'Av. Padre Cícero', 'number' => '2200', 'city' => 'Juazeiro do Norte', 'state' => 'CE', 'zip_code' => '63010-000', 'rent_value' => 1750.00, 'type' => 'Comercial'],
            ['nickname' => 'Casa Salesianos', 'street' => 'Rua São José', 'number' => '95', 'city' => 'Juazeiro do Norte', 'state' => 'CE', 'zip_code' => '63040-000', 'rent_value' => 1400.00, 'type' => 'Casa'],
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