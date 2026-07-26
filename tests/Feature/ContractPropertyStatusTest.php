<?php

namespace Tests\Feature;

use App\Livewire\Contract\Create;
use App\Livewire\Contract\Edit;
use App\Models\Configuration;
use App\Models\Contract;
use App\Models\People;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContractPropertyStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_property_becomes_rented_when_active_contract_is_created(): void
    {
        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);

        $property = Property::factory()->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
            'status' => 'available',
        ]);

        $person = People::factory()->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin);

        Livewire::test(Create::class)
            ->set('property_id', $property->id)
            ->set('people_id', $person->id)
            ->set('start_date', now()->toDateString())
            ->set('payday', 10)
            ->set('rent_value', $property->rent_value)
            ->set('status', 'active')
            ->call('store');

        $this->assertEquals('rented', $property->fresh()->status);
    }

    public function test_property_becomes_available_when_contract_is_finished(): void
    {
        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);

        $property = Property::factory()->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
            'status' => 'rented',
        ]);

        $contract = Contract::factory()->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
            'property_id' => $property->id,
            'status' => 'active',
        ]);

        $this->actingAs($admin);

        Livewire::test(Edit::class, ['contract' => $contract])
            ->set('status', 'finished')
            ->call('update');

        $this->assertEquals('available', $property->fresh()->status);
    }
}