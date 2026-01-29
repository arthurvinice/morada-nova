<?php
// app/Helpers/functions.php

if (!function_exists('getStatusClass')) {
    /**
     * Retorna a classe CSS apropriada para o status da demanda
     *
     * @param string $status
     * @return string
     */
    function getStatusClass($status)
    {
        switch ($status) {
            case 'Em Aberto':
                return 'danger';
            case 'Em Andamento':
                return 'primary';
            case 'Concluída':
                return 'success';
            case 'Concluída Parcialmente':
                return 'warning';
            case 'Concluída Sem Solução':
                return 'secondary';
            case 'Aguardando Processo Licitatório':
                return 'info';
            case 'Aguardando Processo de Compra de Material':
                return 'dark';
            case 'Demanda Reprimida':
                return 'danger';
            default:
                return 'default';
        }
    }
}
