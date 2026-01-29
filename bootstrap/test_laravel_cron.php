<?php
// Este script testa especificamente se o artisan pode ser executado via CLI
$output = shell_exec('/opt/alt/php82/usr/bin/php artisan --version');
file_put_contents(__DIR__ . '/cron_artisan_test.log', date('Y-m-d H:i:s') . " - Resultado: " . $output . PHP_EOL, FILE_APPEND);
