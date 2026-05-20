@props([
    'id', 
    'labels' => [], 
    'data' => [],          // Puede ser un array simple [10, 20] o un JSON de múltiples datasets
    'type' => 'bar', 
    'title' => 'Gráfico',
    'colors' => null,      // Puede ser un string o un array de colores
    'borders' => null,     // Puede ser un string o un array de bordes
    'stacked' => false     // True si quieres barras apiladas
])

<div class="chart-container-js">
    <canvas id="canvas-{{ $id }}" 
            data-labels="{{ json_encode($labels) }}" 
            data-type="{{ $type }}" 
            data-title="{{ $title }}"
            data-stacked="{{ $stacked ? 'true' : 'false' }}">
    </canvas>
</div>

@once
    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.chart-container-js canvas').forEach(canvas => {
                const rawLabels = JSON.parse(canvas.dataset.labels || '[]');
                const isStacked = canvas.dataset.stacked === 'true';
                
                // Intentar parsear el contenido de data-values
                let datasetsStructure = [];
                try {
                    const parsedData = JSON.parse(canvas.dataset.values);
                    
                    // Si el primer elemento es un objeto, viene estructurado para barras agrupadas/stacked desde el controlador
                    if (parsedData.length > 0 && typeof parsedData[0] === 'object' && parsedData[0] !== null) {
                        datasetsStructure = parsedData;
                    } else {
                        // Si es un array simple de números, armamos el dataset estándar de una sola serie
                        const customColors = JSON.parse(canvas.dataset.colors || 'null');
                        const customBorders = JSON.parse(canvas.dataset.borders || 'null');

                        datasetsStructure = [{
                            label: canvas.dataset.title,
                            data: parsedData,
                            backgroundColor: customColors || 'rgba(243, 156, 18, 0.7)',
                            borderColor: customBorders || 'rgba(243, 156, 18, 1)',
                            borderWidth: 1
                        }];
                    }
                } catch (e) {
                    console.error("Error cargando los datos de la gráfica:", e);
                }
                
                new Chart(canvas, {
                    type: canvas.dataset.type,
                    data: {
                        labels: rawLabels,
                        datasets: datasetsStructure
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                stacked: isStacked,
                                ticks: { color: '#ffffff' },
                                grid: { color: 'rgba(255, 255, 255, 0.1)' }
                            },
                            y: {
                                stacked: isStacked,
                                ticks: { color: '#ffffff' },
                                grid: { color: 'rgba(255, 255, 255, 0.1)' }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: { color: '#ffffff' }
                            },
                            tooltip: {
                                backgroundColor: '#ffffff',
                                titleColor: '#111111',
                                bodyColor: '#222222',
                                borderColor: '#e0e0e0',
                                borderWidth: 1,
                                padding: 10
                            }
                        }
                    }
                });
            });
        });
    </script>
    @endpush
@endonce

{{-- Inyección aislada de los datos específicos de esta gráfica --}}
@push('js')
<script>
    (function() {
        const el = document.getElementById("canvas-{{ $id }}");
        el.dataset.values = '{!! json_encode($data) !!}';
        el.dataset.colors = '{!! json_encode($colors) !!}';
        el.dataset.borders = '{!! json_encode($borders) !!}';
    })();
</script>
@endpush