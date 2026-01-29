<?php
// Arquivo para executar o scheduler do Laravel
$rootDir = __DIR__;
chdir($rootDir); // Garantir que estamos no diretório correto

// Registrar execução
file_put_contents(
    $rootDir . '/storage/logs/scheduler-trigger.log',
    date('Y-m-d H:i:s') . ' - Tentando executar o scheduler' . PHP_EOL,
    FILE_APPEND
);

// Executar o comando
$output = shell_exec('php artisan schedule:run 2>&1');

// Registrar resultado
file_put_contents(
    $rootDir . '/storage/logs/scheduler-trigger.log',
    date('Y-m-d H:i:s') . ' - Resultado: ' . $output . PHP_EOL,
    FILE_APPEND
);
