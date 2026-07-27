<?php

namespace Tests\Feature;

use App\Models\Configuration;
use App\Models\People;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_open_edit_for_property_from_another_configuration(): void
    {
        $configurationA = Configuration::factory()->create();
        $configurationB = Configuration::factory()->create();

        $adminA = User::factory()->admin()->create(['configuration_id' => $configurationA->id]);

        $propertyB = Property::factory()->create([
            'configuration_id' => $configurationB->id,
        ]);

        $this->actingAs($adminA);

        $this->get(route('admin.properties.edit', $propertyB->uuid))
            ->assertNotFound();
    }

    public function test_admin_can_open_edit_for_own_configuration_property(): void
    {
        $configurationA = Configuration::factory()->create();
        $adminA = User::factory()->admin()->create(['configuration_id' => $configurationA->id]);

        $propertyA = Property::factory()->create([
            'configuration_id' => $configurationA->id,
            'user_id' => $adminA->id,
        ]);

        $this->actingAs($adminA);

        $this->get(route('admin.properties.edit', $propertyA->uuid))
            ->assertOk();
    }

    public function test_admin_cannot_open_edit_for_person_from_another_configuration(): void
    {
        $configurationA = Configuration::factory()->create();
        $configurationB = Configuration::factory()->create();

        $adminA = User::factory()->admin()->create(['configuration_id' => $configurationA->id]);

        $personB = People::factory()->create([
            'configuration_id' => $configurationB->id,
        ]);

        $this->actingAs($adminA);

        $this->get(route('admin.people.edit', $personB->uuid))
            ->assertNotFound();
    }

    public function test_admin_can_open_edit_for_own_configuration_person(): void
    {
        $configurationA = Configuration::factory()->create();
        $adminA = User::factory()->admin()->create(['configuration_id' => $configurationA->id]);

        $personA = People::factory()->create([
            'configuration_id' => $configurationA->id,
            'user_id' => $adminA->id,
        ]);

        $this->actingAs($adminA);

        $this->get(route('admin.people.edit', $personA->uuid))
            ->assertOk();
    }
}