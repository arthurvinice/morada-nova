<?php

namespace App\Console\Commands;

use App\Models\Address;
use Illuminate\Console\Command;

class GeocodeAddresses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addresses:geocode {--limit=50} {--force : Reprocessar mesmo endereços já geocodificados}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Geocodifica endereços existentes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = $this->option('limit');
        $force = $this->option('force');

        // Query para endereços a serem processados
        $query = Address::query()
            ->whereNotNull('rua')
            ->whereNotNull('numero')
            ->whereNotNull('cidade')
            ->whereNotNull('uf');

        // Se não estamos forçando, pegue apenas endereços não geocodificados
        if (!$force) {
            $query->whereNull('latitude')
            ->orWhereNull('longitude');
        }

        $addresses = $query->take($limit)->get();

        $this->info("Encontrados {$addresses->count()} endereços para geocodificar");

        if ($addresses->isEmpty()) {
            $this->info("Nenhum endereço para processar.");
            return;
        }

        $bar = $this->output->createProgressBar($addresses->count());
        $bar->start();

        $success = 0;
        $failed = 0;

        foreach ($addresses as $address) {
            $result = $address->updateCoordinates();

            if ($result) {
                $success++;
            } else {
                $failed++;
            }

            $bar->advance();

            // Respeitar limites da API
            if (($success + $failed) % 10 == 0) {
                sleep(1);
            }
        }

        $bar->finish();

        $this->newLine(2);
        $this->info("Processamento concluído: {$success} com sucesso, {$failed} com falha.");

        return Command::SUCCESS;
    }
}
