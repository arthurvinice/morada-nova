<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Contract\Create as ContractCreate;
use App\Livewire\People\Create as PeopleCreate;
use App\Models\Configuration;
use App\Models\People;
use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class FileUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_person_document_is_stored_on_create(): void
    {
        Storage::fake('public');

        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);

        $this->actingAs($admin);

        $file = UploadedFile::fake()->create('rg.pdf', 200, 'application/pdf');

        Livewire::test(PeopleCreate::class)
            ->set('name', 'Pessoa Com Documento')
            ->set('cpf', '999.888.777-66')
            ->set('phone', '(84) 90000-0000')
            ->set('document', $file)
            ->call('store')
            ->assertRedirect(route('admin.people.index'));

        $person = People::where('cpf', '999.888.777-66')->first();

        $this->assertNotNull($person->document);
        Storage::disk('public')->assertExists($person->document);
    }

    public function test_contract_file_is_stored_on_create(): void
    {
        Storage::fake('public');

        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);

        $property = Property::factory()->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
            'status' => 'available',
            'rent_value' => 1200,
        ]);

        $person = People::factory()->create([
            'configuration_id' => $configuration->id,
            'user_id' => $admin->id,
        ]);

        $this->actingAs($admin);

        $file = UploadedFile::fake()->create('contrato.pdf', 300, 'application/pdf');

        Livewire::test(ContractCreate::class)
            ->set('property_id', $property->id)
            ->set('people_id', $person->id)
            ->set('start_date', now()->toDateString())
            ->set('payday', 5)
            ->set('rent_value', 1200)
            ->set('status', 'active')
            ->set('file', $file)
            ->call('store')
            ->assertRedirect(route('admin.contracts.index'));

        $this->assertDatabaseHas('contracts', [
            'property_id' => $property->id,
            'people_id' => $person->id,
        ]);

        $contract = \App\Models\Contract::where('property_id', $property->id)->first();

        $this->assertNotNull($contract->file);
        Storage::disk('public')->assertExists($contract->file);
    }

    public function test_invalid_file_type_is_rejected(): void
    {
        Storage::fake('public');

        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);

        $this->actingAs($admin);

        $file = UploadedFile::fake()->create('virus.exe', 100, 'application/x-msdownload');

        Livewire::test(PeopleCreate::class)
            ->set('name', 'Teste Arquivo Inválido')
            ->set('cpf', '555.444.333-22')
            ->set('phone', '(84) 91111-1111')
            ->set('document', $file)
            ->call('store')
            ->assertHasErrors(['document' => 'mimes']);
    }
}