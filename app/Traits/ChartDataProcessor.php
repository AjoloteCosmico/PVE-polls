<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait ChartDataProcessor
{
    /**
     * Gráfico de una sola serie (barras simples).
     */
    public function generateChartData(Builder $query, string $groupByField, string $labelField = null): array
    {
        $labelField = $labelField ?? $groupByField;

        $results = (clone $query)
            ->select(DB::raw($labelField . ' as label'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw($groupByField))
            ->orderBy('label', 'asc')
            ->get();

        return [
            'labels' => $results->pluck('label')->toArray(),
            'data'   => $results->pluck('total')->toArray(),
        ];
    }

    /**
     * Gráfico multilínea/multibarra agrupado por la misma expresión (ej. semana).
     * Devuelve estructura 'labels' y 'datasets' lista para el componente Blade.
     *
     * @param string $groupByExpression  Expresión SQL para agrupar (ej. "date_trunc('week', fec_capt)")
     * @param string $labelExpression    Expresión SQL para la etiqueta (ej. "to_char(date_trunc('week', fec_capt), 'YYYY-MM-DD')")
     * @param array  $series             Arreglo de series, cada una con:
     *    - 'query'         Builder de la consulta base
     *    - 'label'         Nombre de la serie
     *    - 'color'         (opcional) color de fondo
     *    - 'borderColor'   (opcional) color del borde
     *    - 'type'          (opcional) 'line', 'bar', etc. (por defecto 'line' para gráfico de líneas)
     */
    public function generateMultiSeriesChartData(
        string $groupByExpression,
        string $labelExpression,
        array $series
    ): array {
        // 1. Ejecutar cada serie y recolectar sus datos [label => total]
        $seriesResults = [];
        foreach ($series as $i => $config) {
            $data = (clone $config['query'])
                ->select(DB::raw($labelExpression . ' as label'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw($groupByExpression))
                ->orderBy('label', 'asc')
                ->pluck('total', 'label')
                ->toArray();
            $seriesResults[$i] = $data;
        }

        // 2. Unir todas las etiquetas (labels) únicas y ordenarlas
        $allLabels = [];
        foreach ($seriesResults as $data) {
            $allLabels = array_merge($allLabels, array_keys($data));
        }
        $allLabels = array_unique($allLabels);
        sort($allLabels); // Orden natural (para fechas YYYY-MM-DD funciona)

        // 3. Construir datasets normalizados
        $datasets = [];
        foreach ($series as $i => $config) {
            $data = $seriesResults[$i];
            $dataPoints = [];
            foreach ($allLabels as $label) {
                $dataPoints[] = $data[$label] ?? 0;
            }

            $datasets[] = [
                'label'           => $config['label'],
                'data'            => $dataPoints,
                'backgroundColor' => $config['color'] ?? 'rgba(54, 162, 235, 0.2)',
                'borderColor'     => $config['borderColor'] ?? 'rgba(54, 162, 235, 1)',
                'borderWidth'     => 2,
                'type'            => $config['type'] ?? 'line',
                'tension'         => 0.1, // Suavizado ligero para líneas
            ];
        }

        return [
            'labels'   => $allLabels,
            'datasets' => $datasets,
        ];
    }

    /**
     * Gráfico de barras apiladas donde:
     * - Las etiquetas del eje X son periodos fijos (ej. ['Act 2016', 'Seg 2022'])
     * - Cada dataset representa una categoría (ej. encuestador) con un valor para cada periodo.
     *
     * @param array $periodQueries   Arreglo de queries Builder, una por periodo, en el mismo orden que $periodLabels
     * @param string $groupColumn    Columna por la cual agrupar (ej. 'name')
     * @param array $periodLabels    Nombres de los periodos en el eje X
     * @param array $paletteColors   Arreglo de pares [backgroundColor, borderColor] para asignar a cada categoría
     * @return array                 ['labels' => $periodLabels, 'datasets' => [...]]
     */
    public function generateStackedBarByCategoryAcrossPeriods(
        array $periodQueries,
        string $groupColumn,
        array $periodLabels,
        array $paletteColors
    ): array {
        // 1. Ejecutar cada query: obtener [categoria => total]
        $periodData = [];
        foreach ($periodQueries as $i => $query) {
            $periodData[$i] = (clone $query)
                ->select($groupColumn, DB::raw('count(*) as total'))
                ->groupBy($groupColumn)
                ->pluck('total', $groupColumn)
                ->toArray();
        }

        // 2. Todas las categorías únicas
        $allCategories = [];
        foreach ($periodData as $data) {
            $allCategories = array_merge($allCategories, array_keys($data));
        }
        $allCategories = array_unique($allCategories);
        sort($allCategories);

        // 3. Construir datasets
        $datasets = [];
        $colorCount = count($paletteColors);
        foreach ($allCategories as $idx => $category) {
            $data = [];
            foreach ($periodData as $periodIdx => $catData) {
                $data[] = $catData[$category] ?? 0;
            }
            $colorPair = $paletteColors[$idx % $colorCount];
            $datasets[] = [
                'label'           => $category ?: 'Sin Asignar',
                'data'            => $data,
                'backgroundColor' => $colorPair[0],
                'borderColor'     => $colorPair[1],
                'borderWidth'     => 1,
            ];
        }

        return [
            'labels'   => $periodLabels,
            'datasets' => $datasets,
        ];
    }

    /**
     * Gráfico de barras horizontales apiladas comparando dos métricas por categoría (ej. encuestador).
     * Retorna también un coeficiente de efectividad (metric1 / metric2).
     *
     * @param Builder $queryMetric1  Query para primera métrica (ej. encuestas)
     * @param Builder $queryMetric2  Query para segunda métrica (ej. recados)
     * @param string $groupColumn    Columna por la cual agrupar (ej. 'name')
     * @param string $label1         Etiqueta para primera métrica
     * @param string $label2         Etiqueta para segunda métrica
     * @param string $color1         Color para primera métrica
     * @param string $borderColor1   Color borde para primera métrica
     * @param string $color2         Color para segunda métrica
     * @param string $borderColor2   Color borde para segunda métrica
     * @return array                 ['labels' => [...], 'datasets' => [...], 'effectiveness' => [...]]
     */
    public function generateHorizontalStackedWithEffectiveness(
        Builder $queryMetric1,
        Builder $queryMetric2,
        string $groupColumn,
        string $label1 = 'Métrica 1',
        string $label2 = 'Métrica 2',
        string $color1 = 'rgba(54, 162, 235, 0.7)',
        string $borderColor1 = 'rgba(54, 162, 235, 1)',
        string $color2 = 'rgba(255, 99, 132, 0.7)',
        string $borderColor2 = 'rgba(255, 99, 132, 1)'
    ): array {
        // 1. Ejecutar queries: obtener [categoria => total]
        $data1 = (clone $queryMetric1)
            ->select($groupColumn, DB::raw('count(*) as total'))
            ->groupBy($groupColumn)
            ->pluck('total', $groupColumn)
            ->toArray();

        $data2 = (clone $queryMetric2)
            ->select($groupColumn, DB::raw('count(*) as total'))
            ->groupBy($groupColumn)
            ->pluck('total', $groupColumn)
            ->toArray();

        // 2. Todas las categorías únicas, ordenadas
        $allCategories = array_unique(array_merge(array_keys($data1), array_keys($data2)));
        sort($allCategories);

        // 3. Construir datasets y calcular efectividad
        $dataPoints1 = [];
        $dataPoints2 = [];
        $effectiveness = [];

        foreach ($allCategories as $category) {
            $val1 = $data1[$category] ?? 0;
            $val2 = $data2[$category] ?? 0;

            $dataPoints1[] = $val1;
            $dataPoints2[] = $val2;

            // Coeficiente: metric1 / metric2 (evitar división por cero)
            $effectiveness[] = $val2 > 0 ? round($val1 / $val2, 4) : 0;
        }

        $datasets = [
            [
                'label'           => $label1,
                'data'            => $dataPoints1,
                'backgroundColor' => $color1,
                'borderColor'     => $borderColor1,
                'borderWidth'     => 1,
            ],
            [
                'label'           => $label2,
                'data'            => $dataPoints2,
                'backgroundColor' => $color2,
                'borderColor'     => $borderColor2,
                'borderWidth'     => 1,
            ],
        ];

        return [
            'labels'         => $allCategories,
            'datasets'       => $datasets,
            'effectiveness'  => $effectiveness,
        ];
    }
}


/**

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait ChartDataProcessor
{
    
     * Procesa una query para contar registros agrupados por un campo o expresión SQL.
     
    public function generateChartData(Builder $query, string $groupByField, string $labelField = null): array
    {
        $labelField = $labelField ?? $groupByField;

        // 1. Clonamos la query base
        $clonedQuery = (clone $query);

        // 2. Si estamos agrupando por una función compleja (como date_trunc)
        // pasamos una expresión cruda al select y al groupBy para PostgreSQL
        $results = $clonedQuery
            ->select(DB::raw($labelField . ' as label'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw($groupByField)) 
            ->orderBy('label', 'asc')
            ->get();

        return [
            'labels' => $results->pluck('label')->toArray(),
            'data'   => $results->pluck('total')->toArray(),
        ];
    }
}

*/