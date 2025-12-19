<x-app-layout-admin>

    <div class="container">
        <h1 class="mb-4">
            {{ $question->survey->title }} – Question Wise Report
        </h1>

        <div class="card mb-5">
            <div class="card-header bg-light-success">
                <h3 class="mb-0">
                    {{ $question->question_text }}
                </h3>
            </div>

            <div class="card-body">
                <canvas id="questionChart" height="120"></canvas>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-light">
                ← Back
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
document.addEventListener("DOMContentLoaded", function () {

    const chartData = @json($chartData);

    const ctx = document
        .getElementById('questionChart')
        .getContext('2d');

    // 🔥 REGISTER PLUGIN
    Chart.register(ChartDataLabels);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: chartData.question_text,
                data: chartData.data,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: chartData.question_text,
                    font: { size: 18 }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#000',
                    font: {
                        weight: 'bold',
                        size: 12
                    },
                    formatter: (value) => value
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
});
</script>

</x-app-layout-admin>
