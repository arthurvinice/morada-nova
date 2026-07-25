<div>
     <div class="row g-4 mb-4">
          <div class="col-sm-6 col-xl-3">
               <div class="card h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                         <div>
                              <p class="text-muted mb-1">Imóveis cadastrados</p>
                              <h4 class="mb-0">{{ $totalProperties }}</h4>
                         </div>
                         <span class="badge bg-label-primary rounded p-2">
                              <i class="icon-base ti tabler-building icon-lg"></i>
                         </span>
                    </div>
               </div>
          </div>

          <div class="col-sm-6 col-xl-3">
               <div class="card h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                         <div>
                              <p class="text-muted mb-1">Disponíveis / Alugados</p>
                              <h4 class="mb-0">{{ $availableProperties }} / {{ $rentedProperties }}</h4>
                         </div>
                         <span class="badge bg-label-success rounded p-2">
                              <i class="icon-base ti tabler-key icon-lg"></i>
                         </span>
                    </div>
               </div>
          </div>

          <div class="col-sm-6 col-xl-3">
               <div class="card h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                         <div>
                              <p class="text-muted mb-1">Contratos ativos</p>
                              <h4 class="mb-0">{{ $activeContracts }}</h4>
                         </div>
                         <span class="badge bg-label-info rounded p-2">
                              <i class="icon-base ti tabler-file-text icon-lg"></i>
                         </span>
                    </div>
               </div>
          </div>

          <div class="col-sm-6 col-xl-3">
               <div class="card h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                         <div>
                              <p class="text-muted mb-1">Receita mensal ativa</p>
                              <h4 class="mb-0">R$ {{ number_format($monthlyRevenue, 2, ',', '.') }}</h4>
                         </div>
                         <span class="badge bg-label-warning rounded p-2">
                              <i class="icon-base ti tabler-cash icon-lg"></i>
                         </span>
                    </div>
               </div>
          </div>
     </div>

     <div class="row g-4 mb-4">
          <div class="col-xl-8">
               <div class="card h-100">
                    <h5 class="card-header">Receita dos últimos 6 meses</h5>
                    <div class="card-body">
                         <div id="revenueChart" wire:ignore></div>
                    </div>
               </div>
          </div>

          <div class="col-xl-4">
               <div class="card h-100">
                    <h5 class="card-header">Imóveis alugados por cidade</h5>
                    <div class="card-body">
                         @if ($rentedByCityChart['labels']->isEmpty())
                         <div class="d-flex flex-column align-items-center justify-content-center text-center py-5">
                              <i class="icon-base ti tabler-building-off icon-xl text-muted mb-2"></i>
                              <p class="text-muted mb-0">Nenhum imóvel alugado no momento</p>
                         </div>
                         @else
                         <div id="rentedByCityChart" wire:ignore></div>
                         @endif
                    </div>
               </div>
          </div>
     </div>

     <div class="card">
          <h5 class="card-header">Próximos Alugueis</h5>
          <div class="table-responsive text-nowrap">
               <table class="table">
                    <thead>
                         <tr>
                              <th>Inquilino</th>
                              <th>Endereço</th>
                              <th>Dia de vencimento</th>
                              <th>Valor</th>
                              <th>Ações</th>
                         </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                         @forelse ($upcomingRents as $contract)
                         <tr>
                              <td>
                                   <i class="icon-base ti tabler-user icon-md text-primary me-2"></i>
                                   <span class="fw-medium">{{ $contract->people->name }}</span>
                              </td>
                              <td>{{ $contract->property->nickname ?: $contract->property->street . ', ' . $contract->property->number }}</td>
                              <td>Dia {{ $contract->payday }}</td>
                              <td>R$ {{ number_format($contract->rent_value, 2, ',', '.') }}</td>
                              <td>
                                   <a class="btn rounded-pill btn-outline-secondary waves-effect btn-sm"
                                        href="{{ route('admin.contracts.edit', $contract->id) }}">
                                        <i class="icon-base ti tabler-eye"></i>
                                   </a>
                              </td>
                         </tr>
                         @empty
                         <tr>
                              <td colspan="5" class="text-center">Nenhum contrato ativo no momento</td>
                         </tr>
                         @endforelse
                    </tbody>
               </table>
          </div>
     </div>

     @script
     <script>
          const revenueChart = new ApexCharts(document.querySelector('#revenueChart'), {
               chart: {
                    type: 'area',
                    height: 300,
                    toolbar: {
                         show: false
                    }
               },
               series: [{
                    name: 'Receita',
                    data: @json($revenueChart['values'])
               }],
               xaxis: {
                    categories: @json($revenueChart['labels'])
               },
               dataLabels: {
                    enabled: false
               },
               stroke: {
                    curve: 'smooth',
                    width: 2
               },
               colors: ['#696cff'],
               yaxis: {
                    labels: {
                         formatter: (val) => 'R$ ' + val.toLocaleString('pt-BR')
                    }
               },
          });
          revenueChart.render();

          const rentedByCityChart = new ApexCharts(document.querySelector('#rentedByCityChart'), {
               chart: {
                    type: 'donut',
                    height: 300
               },
               series: @json($rentedByCityChart['values']),
               labels: @json($rentedByCityChart['labels']),
               legend: {
                    position: 'bottom'
               },
               dataLabels: {
                    enabled: true
               },
          });
          rentedByCityChart.render();
     </script>
     @endscript
</div>