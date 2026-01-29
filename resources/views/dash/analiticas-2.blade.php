@extends('app')

@section('title') Dashboard Analitica @endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link href="{{ asset('assets/vendor/libs/select2/select2.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}">

@endpush

@section('content')


<div class="container-fluid">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <!-- Gráfico 1: Pessoas cadastradas -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 text-body">Pessoas Cadastradas</p>
                    </div>
                    <h4 class="card-title mb-1">{{ $totalPeople }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-4">
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <span class="badge bg-label-info p-1 rounded">
                                    <i class="ti ti-man ti-sm"></i>
                                </span>
                                <p class="mb-0">Homens</p>
                            </div>
                            <h5 class="mb-0 pt-1">{{ $genderStats['male']['count'] }} ({{ $genderStats['male']['percentage'] }}%)</h5>
                        </div>
                        <div class="col-4">
                            <div class="divider divider-vertical">
                                <div class="divider-text">
                                    <span class="badge-divider-bg bg-label-secondary">VS</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                <p class="mb-0">Mulheres</p>
                                <span class="badge bg-label-primary p-1 rounded">
                                    <i class="ti ti-woman ti-sm"></i>
                                </span>
                            </div>
                            <h5 class="mb-0 pt-1">{{ $genderStats['female']['count'] }} ({{ $genderStats['female']['percentage'] }}%)</h5>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-6">
                        <div class="progress w-100" style="height: 10px">
                            <div class="progress-bar bg-info" style="width: {{ $genderStats['male']['percentage'] }}%" role="progressbar" aria-valuenow="{{ $genderStats['male']['count'] }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $genderStats['female']['percentage'] }}%" aria-valuenow="{{ $genderStats['female']['count'] }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico 2: Faixa Etária -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Faixa Etária</h5>
                    <canvas id="ageGroupChart"></canvas>
                </div>
            </div>
        </div>





    </div> {{-- fim row --}}

    <div class="row">
        <!-- Nova Tabela: Estatísticas de Bairros -->
        <div class="col-xxl-4 col-md-6 mb-4 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h4 class="card-title">Estatísticas de Bairros</h4>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">

                        @foreach($neighborhoodStats as $neighborhood)

                        <li class="mb-4 d-flex">
                            <div class="d-flex w-50 align-items-center me-4">

                                <span class="badge badge-center rounded-pill bg-label-secondary">{{ $neighborhood->count
                                    }}</span>

                                <div class="px-3">
                                    <h6 class="mb-0">{{ $neighborhood->bairro }}</h6>
                                </div>
                            </div>
                            <div class="d-flex flex-grow-1 align-items-center">
                                <div class="progress w-100 me-4" style="height: 8px">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $neighborhood->percentage }}%" aria-valuenow="54" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <span class="text-muted">{{ $neighborhood->percentage }}%</span>
                            </div>
                        </li>

                        @endforeach

                    </ul>
                </div>
            </div>
        </div>

        <!-- Gráfico 3: Mapa -->
        <div class="col-xxl-8 col-md-6 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mapa de Pessoas</h5>
                    <div id="map" style="min-height: 400px; max-height: 800px"></div>
                </div>
            </div>
        </div>

        <!-- Lista de Cadastros Incompletos -->



    </div> {{-- fim row --}}

    <div class="row">

    </div> {{-- fim row --}}



</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/js/cards-advance.js') }}"></script>

<script>

        // Gráfico de Faixa Etária
        var ctx = document.getElementById('ageGroupChart').getContext('2d');
        var ageGroupData = @json($ageGroups);
        var labels = ageGroupData.map(item => item.age_group);
        var data = ageGroupData.map(item => item.count);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Número de Pessoas',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Quantidade: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });

       // Mapa
    document.addEventListener('DOMContentLoaded', function() {
    var map = L.map('map').setView([-14.2350, -51.9253], 4); // Centro do Brasil

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var addresses = @json($addresses);
    console.log('Addresses:', addresses);

    if (addresses && addresses.length > 0) {
    var bounds = L.latLngBounds();
    addresses.forEach(function(address) {

    if (address.lat && address.lng) {
    var marker = L.marker([parseFloat(address.lat), parseFloat(address.lng)]).addTo(map);
    marker.bindPopup(address.name + '<br>' + address.address);
    bounds.extend([parseFloat(address.lat), parseFloat(address.lng)]);
    } else {
    console.warn('Invalid coordinates for:', address);
    }

    });

    if (bounds.isValid()) {
    map.fitBounds(bounds);
    } else {
    console.warn('No valid bounds to fit');
    }
    } else {
    console.log('No addresses to display');
    // Adicionar um marcador de teste para verificar se o mapa está funcionando
    L.marker([-14.2350, -51.9253]).addTo(map)
    .bindPopup('Marcador de teste')
    .openPopup();
    }

    });

</script>

@endpush
