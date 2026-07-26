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

class DashboardUpcomingRentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_upcoming_rents_are_ordered_by_closest_payday(): void
    {
        $configuration = Configuration::factory()->create();
        $admin = User::factory()->admin()->create(['configuration_id' => $configuration->id]);

        $today = now()->day;

        // paydays propositalmente fora de ordem, incluindo um "já passou este mês"
        // e um exatamente no dia de hoje, para validar o wrap-around do módulo.
        $paydays = [
            $this->wrapDay($today + 10), // daqui a 10 dias
            $this->wrapDay($today - 5),  // já passou, cai pro próximo mês (+31)
            $this->wrapDay($today),      // vence hoje (diff = 0, deve vir primeiro)
            $this->wrapDay($today + 2),  // daqui a 2 dias
        ];

        $contracts = collect($paydays)->map(function ($payday) use ($configuration, $admin) {
            $property = Property::factory()->create([
                'configuration_id' => $configuration->id,
                'user_id' => $admin->id,
            ]);

            $person = People::factory()->create([
                'configuration_id' => $configuration->id,
                'user_id' => $admin->id,
            ]);

            return Contract::factory()->create([
                'configuration_id' => $configuration->id,
                'user_id' => $admin->id,
                'property_id' => $property->id,
                'people_id' => $person->id,
                'status' => 'active',
                'payday' => $payday,
            ]);
        });

        $this->actingAs($admin);

        $upcoming = Livewire::test(Index::class)->viewData('upcomingRents');

        $orderedPaydays = $upcoming->pluck('payday')->values()->all();

        // o primeiro da lista deve ser o payday de hoje (diff = 0)
        $this->assertEquals($paydays[2], $orderedPaydays[0]);

        // o que já passou (virou +31) deve ficar por último entre os 4
        $this->assertEquals($paydays[1], $orderedPaydays[3]);
    }

    /**
     * Garante que o dia gerado fique dentro do intervalo válido (1–28),
     * simulando o "wrap" de mês sem depender de meses com 30/31 dias.
     */
    private function wrapDay(int $day): int
    {
        $day = $day % 28;

        return $day <= 0 ? $day + 28 : $day;
    }
}