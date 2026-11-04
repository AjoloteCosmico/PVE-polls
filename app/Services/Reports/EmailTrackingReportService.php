<?php

namespace App\Services\Reports;

/**
 * Servicio de reportes de correos y email tracking.
 *
 * Objetivo final:
 * - Centralizar la extracción y procesamiento de todos los datos de `email_tracking`.
 * - Separar el cálculo de envíos, aperturas, clics y tasa de apertura.
 * - Proveer un payload estándar para mostrar tablas y gráficas por tipo de correo.
 *
 * Alcance inicial:
 * - tipo de email: aviso, especialidad, act_encuesta, posgrado, verde, correo_seg_22, etc.
 * - métricas de envíos y aperturas
 * - volumen histórico por fecha
 * - comparación por tipo de correo
 *
 * Contracto esperado:
 * ```php
 * [
 *     'title' => 'Correos',
 *     'period' => ['start' => '2026-10-01', 'end' => '2026-10-31'],
 *     'totals' => ['enviados' => 2450, 'abiertos' => 980],
 *     'by_type' => [
 *         ['type' => 'aviso', 'enviados' => 800, 'abiertos' => 300, 'tasa_apertura' => 37.5],
 *     ],
 *     'by_date' => [...],
 *     'chart' => [...],
 *     'table' => [...],
 * ]
 * ```
 *
 * Reglas:
 * - El servicio no debe depender de Blade.
 * - Las métricas se calculan en una sola capa y se consumen por la pestaña de correos.
 * - Debe poder reutilizarse en la vista de dashboard y en el correo semanal.
 */
class EmailTrackingReportService
{
    /**
     * Devuelve métricas de correos por tipo.
     *
     * @param array $filters
     * @return array
     */
    public function byType(array $filters = []): array
    {
        // Se implementará en la siguiente fase.
        return [];
    }

    /**
     * Devuelve métricas por fecha para series históricas.
     *
     * @param array $filters
     * @return array
     */
    public function byDate(array $filters = []): array
    {
        // Se implementará en la siguiente fase.
        return [];
    }

    /**
     * Devuelve el resumen general para panel de correos.
     *
     * @param array $filters
     * @return array
     */
    public function summary(array $filters = []): array
    {
        // Se implementará en la siguiente fase.
        return [];
    }
}
