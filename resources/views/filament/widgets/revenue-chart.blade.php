<div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
    <h3 class="text-sm font-medium text-gray-500 mb-2">Ingresos Últimos 6 Meses</h3>
    <canvas id="revenue-chart" data-chart="{{ json_encode($chartData) }}"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenue-chart');
    const data = @json($chartData);

    if (ctx && data.labels) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Ingresos (€)',
                    data: data.data,
                    backgroundColor: '#fbbf24',
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    }
});
</script>