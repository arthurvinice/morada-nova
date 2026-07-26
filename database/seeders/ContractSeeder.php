<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        $admin = DB::table('users')->where('role', 'admin')->first();

        $properties = DB::table('properties')
            ->where('configuration_id', $admin->configuration_id)
            ->get()
            ->shuffle();

        $people = DB::table('people')
            ->where('configuration_id', $admin->configuration_id)
            ->get()
            ->shuffle();

        $totalContracts = min($properties->count(), $people->count() - 3);

        $contracts = [];

        for ($i = 0; $i < $totalContracts; $i++) {
            $property = $properties[$i];
            $person = $people[$i];

            $contracts[] = [
                'uuid'             => (string) Str::uuid(),
                'start_date'       => now()->subMonths(rand(1, 10))->toDateString(),
                'end_date'         => null,
                'payday'           => rand(1, 28),
                'rent_value'       => $property->rent_value,
                'status'           => 'active',
                'file'             => null,
                'property_id'      => $property->id,
                'people_id'        => $person->id,
                'user_id'          => $admin->id,
                'configuration_id' => $admin->configuration_id,
                'created_at'       => now(),
                'updated_at'       => now(),
            ];

            DB::table('properties')->where('id', $property->id)->update(['status' => 'rented']);
        }

        DB::table('contracts')->insert($contracts);
    }
}