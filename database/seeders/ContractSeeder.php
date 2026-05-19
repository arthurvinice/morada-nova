<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        $userId = DB::table('users')->where('role', 'admin')->value('id');

        $rentedProperties = DB::table('properties')->where('status', 'rented')->get();
        $people           = DB::table('people')->pluck('id')->toArray();

        $contracts = [];

        foreach ($rentedProperties as $index => $property) {
            $contracts[] = [
                'start_date'  => now()->subMonths(3)->toDateString(),
                'end_date'    => now()->addMonths(9)->toDateString(),
                'rent_value'  => $property->rent_value,
                'status'      => 'active',
                'property_id' => $property->id,
                'people_id'   => $people[$index % count($people)],
                'user_id'     => $userId,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        DB::table('contracts')->insert($contracts);
    }
}