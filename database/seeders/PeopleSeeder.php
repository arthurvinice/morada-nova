<?php

namespace Database\Seeders;

use App\Models\People;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeopleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = DB::table('users')->where('email', 'admin@teste.com')->first();

        $people = [
            ['name' => 'Maria Oliveira Souza', 'cpf' => '111.222.333-44', 'phone' => '(84) 99111-2233', 'email' => 'maria.souza@email.com'],
            ['name' => 'João Pedro Lima', 'cpf' => '222.333.444-55', 'phone' => '(84) 99222-3344', 'email' => 'joao.lima@email.com'],
            ['name' => 'Ana Beatriz Costa', 'cpf' => '333.444.555-66', 'phone' => '(84) 99333-4455', 'email' => 'ana.costa@email.com'],
            ['name' => 'Carlos Eduardo Ferreira', 'cpf' => '444.555.666-77', 'phone' => '(84) 99444-5566', 'email' => null],
            ['name' => 'Fernanda Alves Rocha', 'cpf' => '555.666.777-88', 'phone' => '(84) 99555-6677', 'email' => 'fernanda.rocha@email.com'],
            ['name' => 'Rafael Nunes Barbosa', 'cpf' => '666.777.888-99', 'phone' => '(84) 99666-7788', 'email' => 'rafael.barbosa@email.com'],
            ['name' => 'Juliana Pereira Dias', 'cpf' => '777.888.999-00', 'phone' => '(84) 99777-8899', 'email' => 'juliana.dias@email.com'],
            ['name' => 'Bruno Henrique Martins', 'cpf' => '888.999.000-11', 'phone' => '(84) 99888-9900', 'email' => null],
            ['name' => 'Camila Fernandes Araújo', 'cpf' => '999.000.111-22', 'phone' => '(84) 99999-0011', 'email' => 'camila.araujo@email.com'],
            ['name' => 'Diego Santos Cardoso', 'cpf' => '000.111.222-33', 'phone' => '(84) 99000-1122', 'email' => 'diego.cardoso@email.com'],
            ['name' => 'Larissa Gomes Ribeiro', 'cpf' => '123.456.789-01', 'phone' => '(84) 99123-4567', 'email' => 'larissa.ribeiro@email.com'],
            ['name' => 'Thiago Almeida Correia', 'cpf' => '234.567.890-12', 'phone' => '(84) 99234-5678', 'email' => null],
            ['name' => 'Patrícia Ramos Teixeira', 'cpf' => '345.678.901-23', 'phone' => '(84) 99345-6789', 'email' => 'patricia.teixeira@email.com'],
            ['name' => 'Gustavo Mendes Carvalho', 'cpf' => '456.789.012-34', 'phone' => '(84) 99456-7890', 'email' => 'gustavo.carvalho@email.com'],
            ['name' => 'Vanessa Cunha Moreira', 'cpf' => '567.890.123-45', 'phone' => '(84) 99567-8901', 'email' => 'vanessa.moreira@email.com'],
        ];

        foreach ($people as $person) {
            People::create([
                ...$person,
                'user_id' => $admin->id,
                'configuration_id' => $admin->configuration_id,
            ]);
        }
    }
}