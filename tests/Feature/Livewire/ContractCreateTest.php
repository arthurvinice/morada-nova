<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Contract\Create;
use App\Models\Configuration;
use App\Models\People;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContractCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_contract_with_mocked_data(): void
    {
        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);

        $property = Property::factory()->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
            'status' => 'available',
            'rent_value' => 1500,
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
            ->set('rent_value', 1500)
            ->set('status', 'active')
            ->call('store')
            ->assertRedirect(route('admin.contracts.index'));

        $this->assertDatabaseHas('contracts', [
            'property_id' => $property->id,
            'people_id' => $person->id,
            'status' => 'active',
            'configuration_id' => $configuration->id,
        ]);
    }
}