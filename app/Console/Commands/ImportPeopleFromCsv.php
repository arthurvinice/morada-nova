<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PeopleImportService;

class ImportPeopleFromCsv extends Command
{
    protected $signature = 'people:import-csv {file} {--skip-header=1}';
    protected $description = 'Importa pessoas de um arquivo CSV';

    protected $importService;

    public function __construct(PeopleImportService $importService)
    {
        parent::__construct();
        $this->importService = $importService;
    }

    public function handle()
    {
        $filePath = $this->argument('file');
        $skipHeader = (bool) $this->option('skip-header');

        $this->info("Iniciando importação do arquivo: {$filePath}");

        try {
            $result = $this->importService->importFromCsv($filePath, $skipHeader);

            $this->info("Importação concluída!");
            $this->info("Total de linhas processadas: {$result['total_rows']}");
            $this->info("Pessoas importadas: {$result['imported']}");
            $this->warn("Linhas com erro/puladas: {$result['skipped']}");

            if (!empty($result['errors'])) {
                $this->error("\nErros encontrados:");
                foreach ($result['errors'] as $error) {
                    $this->error("Linha {$error['row']}: " . json_encode($error['errors']));
                }
            }

        } catch (\Exception $e) {
            $this->error("Erro na importação: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
