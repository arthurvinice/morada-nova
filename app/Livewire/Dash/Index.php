<?php

namespace App\Livewire\Dash;

use App\Models\Contract;
use App\Models\People;
use App\Models\Property;
use Livewire\Component;

class Index extends Component
{
    public function getUpcomingRentsProperty()
    {
        return Contract::with('property', 'people')
            ->where('status', 'active')
            ->get()
            ->sortBy(function ($contract) {
                $today = now()->day;
                $diff = $contract->payday - $today;

                return $diff < 0 ? $diff + 31 : $diff;
            })
            ->take(5);
    }

    public function getRevenueChartProperty()
    {
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i));

        $labels = $months->map(fn ($month) => ucfirst($month->translatedFormat('M/Y')));

        $values = $months->map(function ($month) {
            return Contract::where('status', 'active')
                ->where('start_date', '<=', $month->endOfMonth())
                ->where(function ($q) use ($month) {
                    $q->whereNull('end_date')->orWhere('end_date', '>=', $month->startOfMonth());
                })
                ->sum('rent_value');
        });

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    public function getRentedByCityChartProperty()
    {
        $data = Property::where('status', 'rented')
            ->selectRaw('city, count(*) as total')
            ->groupBy('city')
            ->orderByDesc('total')
            ->get();

        return [
            'labels' => $data->pluck('city'),
            'values' => $data->pluck('total'),
        ];
    }

    public function render()
    {
        return view('livewire.dash.index', [
            'totalProperties'     => Property::count(),
            'availableProperties' => Property::where('status', 'available')->count(),
            'rentedProperties'    => Property::where('status', 'rented')->count(),
            'totalPeople'         => People::count(),
            'activeContracts'     => Contract::where('status', 'active')->count(),
            'monthlyRevenue'      => Contract::where('status', 'active')->sum('rent_value'),
            'upcomingRents'       => $this->upcomingRents,
            'revenueChart'        => $this->revenueChart,
            'rentedByCityChart'   => $this->rentedByCityChart,
        ]);
    }
}