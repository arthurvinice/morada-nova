<?php

namespace Tests\Feature\Livewire;

use App\Livewire\People\Create;
use App\Models\Configuration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PeopleCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_person_with_mocked_data(): void
    {
        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);

        $this->actingAs($admin);

        Livewire::test(Create::class)
            ->set('name', 'Maria Teste da Silva')
            ->set('cpf', '123.456.789-00')
            ->set('phone', '(84) 99999-0000')
            ->set('email', 'maria.teste@email.com')
            ->call('store')
            ->assertRedirect(route('admin.people.index'));

        $this->assertDatabaseHas('people', [
            'name' => 'Maria Teste da Silva',
            'cpf' => '123.456.789-00',
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
        ]);
    }

    public function test_cpf_must_be_unique(): void
    {
        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);

        \App\Models\People::factory()->create([
            'cpf' => '111.222.333-44',
            'configuration_id' => $configuration->id,
        ]);

        $this->actingAs($admin);

        Livewire::test(Create::class)
            ->set('name', 'Outra Pessoa')
            ->set('cpf', '111.222.333-44')
            ->set('phone', '(84) 98888-0000')
            ->call('store')
            ->assertHasErrors(['cpf' => 'unique']);
    }
}