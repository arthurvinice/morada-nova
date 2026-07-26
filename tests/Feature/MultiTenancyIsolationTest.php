<?php

namespace Tests\Feature;

use App\Models\Configuration;
use App\Models\Contract;
use App\Models\People;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiTenancyIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_see_properties_from_another_configuration(): void
    {
        $configurationA = Configuration::factory()->create();
        $configurationB = Configuration::factory()->create();

        $adminA = User::factory()->admin()->create(['configuration_id' => $configurationA->id]);
        $adminB = User::factory()->admin()->create(['configuration_id' => $configurationB->id]);

        $propertyA = Property::factory()->create([
            'configuration_id' => $configurationA->id,
            'user_id' => $adminA->id,
        ]);

        $propertyB = Property::factory()->create([
            'configuration_id' => $configurationB->id,
            'user_id' => $adminB->id,
        ]);

        $this->actingAs($adminA);

        $visiveis = Property::all();

        $this->assertTrue($visiveis->contains($propertyA));
        $this->assertFalse($visiveis->contains($propertyB));
    }

    public function test_superadmin_sees_properties_from_all_configurations(): void
    {
        $configurationA = Configuration::factory()->create();
        $configurationB = Configuration::factory()->create();

        $superadmin = User::factory()->superadmin()->create();

        Property::factory()->create(['configuration_id' => $configurationA->id]);
        Property::factory()->create(['configuration_id' => $configurationB->id]);

        $this->actingAs($superadmin);

        $this->assertCount(2, Property::all());
    }

    public function test_admin_cannot_see_people_from_another_configuration(): void
    {
        $configurationA = Configuration::factory()->create();
        $configurationB = Configuration::factory()->create();

        $adminA = User::factory()->admin()->create(['configuration_id' => $configurationA->id]);
        $adminB = User::factory()->admin()->create(['configuration_id' => $configurationB->id]);

        $personA = People::factory()->create([
            'configuration_id' => $configurationA->id,
            'user_id' => $adminA->id,
        ]);

        $personB = People::factory()->create([
            'configuration_id' => $configurationB->id,
            'user_id' => $adminB->id,
        ]);

        $this->actingAs($adminA);

        $visiveis = People::all();

        $this->assertTrue($visiveis->contains($personA));
        $this->assertFalse($visiveis->contains($personB));
    }

    public function test_admin_cannot_see_contracts_from_another_configuration(): void
    {
        $configurationA = Configuration::factory()->create();
        $configurationB = Configuration::factory()->create();

        $adminA = User::factory()->admin()->create(['configuration_id' => $configurationA->id]);
        $adminB = User::factory()->admin()->create(['configuration_id' => $configurationB->id]);

        $contractA = Contract::factory()->create([
            'configuration_id' => $configurationA->id,
            'user_id' => $adminA->id,
        ]);

        $contractB = Contract::factory()->create([
            'configuration_id' => $configurationB->id,
            'user_id' => $adminB->id,
        ]);

        $this->actingAs($adminA);

        $visiveis = Contract::all();

        $this->assertTrue($visiveis->contains($contractA));
        $this->assertFalse($visiveis->contains($contractB));
    }
}