<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Property\Create;
use App\Models\Configuration;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PropertyCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_property_with_mocked_data(): void
    {
        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);
        $type = PropertyType::factory()->create(['name' => 'Apartamento']);

        $this->actingAs($admin);

        Livewire::test(Create::class)
            ->set('nickname', 'Apto Teste 101')
            ->set('zip_code', '59000-000')
            ->set('street', 'Rua de Teste')
            ->set('number', '101')
            ->set('city', 'Natal')
            ->set('state', 'RN')
            ->set('rent_value', 1500)
            ->set('status', 'available')
            ->set('property_type_id', $type->id)
            ->call('store')
            ->assertRedirect(route('admin.properties.index'));

        $this->assertDatabaseHas('properties', [
            'nickname' => 'Apto Teste 101',
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
        ]);
    }
}