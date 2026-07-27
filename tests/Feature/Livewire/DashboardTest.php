<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Dash\Index;
use App\Models\Configuration;
use App\Models\Contract;
use App\Models\People;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_counts_match_seeded_data(): void
    {
        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);

        Property::factory()->count(3)->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
            'status' => 'available',
        ]);

        $rentedProperties = Property::factory()->count(2)->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
            'status' => 'rented',
        ]);

        People::factory()->count(4)->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
        ]);

        $tenants = People::factory()->count(2)->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
        ]);

        foreach ($rentedProperties as $index => $property) {
            Contract::factory()->create([
                'configuration_id' => $configuration->id,
                'user_id' => $admin->id,
                'property_id' => $property->id,
                'people_id' => $tenants[$index]->id,
                'status' => 'active',
                'rent_value' => 1000,
            ]);
        }

        $this->actingAs($admin);

        $component = Livewire::test(Index::class);

        $this->assertEquals(5, $component->viewData('totalProperties'));
        $this->assertEquals(3, $component->viewData('availableProperties'));
        $this->assertEquals(2, $component->viewData('rentedProperties'));
        $this->assertEquals(6, $component->viewData('totalPeople'));
        $this->assertEquals(2, $component->viewData('activeContracts'));
        $this->assertEquals(2000, (float) $component->viewData('monthlyRevenue'));
    }

    public function test_rented_by_city_chart_groups_correctly(): void
    {
        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);

        Property::factory()->count(2)->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
            'status' => 'rented',
            'city' => 'Natal',
        ]);

        Property::factory()->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
            'status' => 'rented',
            'city' => 'Fortaleza',
        ]);

        Property::factory()->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
            'status' => 'available',
            'city' => 'Natal',
        ]);

        $this->actingAs($admin);

        $chart = Livewire::test(Index::class)->viewData('rentedByCityChart');

        $this->assertEquals(['Natal', 'Fortaleza'], $chart['labels']->values()->all());
        $this->assertEquals([2, 1], $chart['values']->values()->all());
    }
}