<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestCron extends Command
{
    protected $signature = 'test:cron';
    protected $description = 'Test if cron is working';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timestamp = now()->format('Y-m-d H:i:s');
        $message = "Teste CRON executado em {$timestamp}";

        Log::info($message);
        file_put_contents(
            storage_path('logs/test-cron.log'),
            $message . PHP_EOL,
            FILE_APPEND
        );

        return Command::SUCCESS;
    }
}
