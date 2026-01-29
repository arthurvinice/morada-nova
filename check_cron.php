<?php
// Arquivo para testar se o CRON está funcionando
file_put_contents(
    __DIR__ . '/storage/logs/cron_check.log',
    date('Y-m-d H:i:s') . ' - CRON executado' . PHP_EOL,
    FILE_APPEND
);
echo "CRON check executed at " . date('Y-m-d H:i:s');
