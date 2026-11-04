<?php

namespace App\Services\Reports;

/**
 * Contrato de salida estándar para reportes del sistema.
 *
 * Objetivo final:
 * - Garantizar que todo reporte, ya sea de encuestas, correos o actividad,
 *   pueda mostrarse como tabla o como gráfica sin reescribir la lógica en la vista.
 * - Permitir reutilizar el mismo formato en vistas web y correos HTML.
 * - Evitar la dispersión de agregaciones dentro de controladores, blades y jobs.
 *
 * Contracto de datos:
 * - Cada servicio debe devolver un arreglo asociativo con la estructura mínima.
 * - Los datos deben estar normalizados antes de la renderización.
 * - La vista solo consume este formato; no debe calcular agregados ni re-filtrar.
 *
 * Estructura de referencia:
 * ```php
 * [
 *     'title' => 'Nombre del reporte',
 *     'period' => [
 *         'start' => '2026-10-01',
 *         'end' => '2026-10-31',
 *     ],
 *     'totals' => [
 *         'general' => 1250,
 *         'telefonicas' => 780,
 *         'internet' => 470,
 *         'no_contestadas' => 120,
 *     ],
 *     'summary' => [
 *         ['label' => '2022', 'total' => 800, 'telefonicas' => 500, 'internet' => 300],
 *     ],
 *     'by_user' => [
 *         ['user' => 'Ana', 'clave' => '27', 'total' => 42],
 *     ],
 *     'by_date' => [
 *         ['date' => '2026-10-20', 'total' => 18],
 *     ],
 *     'by_type' => [
 *         ['type' => 'aviso', 'total' => 120],
 *     ],
 *     'chart' => [
 *         'type' => 'doughnut',
 *         'labels' => ['Internet', 'Telefónicas', 'No realizadas'],
 *         'datasets' => [
 *             ['label' => 'Total', 'data' => [470, 780, 120]],
 *         ],
 *     ],
 *     'table' => [
 *         'headers' => ['Estudio', 'Telefónicas', 'Internet', 'Total'],
 *         'rows' => [
 *             ['Estudio', 500, 300, 800],
 *         ],
 *     ],
 * ];
 * ```
 *
 * Reglas:
 * - Los nombres de campos deben ir en español o en un vocabulario estándar del negocio.
 * - No usar estructuras ad-hoc por vista.
 * - Todo reporte debe poder convertirse en tabla o gráfica sin lógica de negocio en Blade.
 * - Los mismos datos pueden enviarse a la vista web y a un correo usando `mails/report.blade.php`.
 *
 * Este archivo funciona como contrato documental para que los servicios se ajusten
 * a una interfaz compartida y legible para auditoría y mantenimiento.
 */
class ReportDataContract
{
    // Documento vivo: se completará con la estructura final consolidada cuando se estabilice el primer conjunto de reportes.
}
