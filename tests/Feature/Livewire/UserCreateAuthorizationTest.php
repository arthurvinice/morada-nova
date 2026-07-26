<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Users\Create;
use App\Models\Configuration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserCreateAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_standard_user_cannot_access_user_create(): void
    {
        $configuration = Configuration::factory()->create();
        $standardUser = User::factory()->create([
            'configuration_id' => $configuration->id,
            'role' => 'standard',
        ]);

        $this->actingAs($standardUser);

        Livewire::test(Create::class)
            ->assertStatus(403);
    }

    public function test_admin_can_access_user_create(): void
    {
        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);

        $this->actingAs($admin);

        Livewire::test(Create::class)
            ->assertStatus(200);
    }
}