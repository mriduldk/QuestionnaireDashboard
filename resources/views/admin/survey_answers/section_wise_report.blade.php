<x-app-layout-admin>

    <div class="container">
        <h1>{{ $survey->title }} - Section Wise Report</h1>

        @foreach($chartData as $sIndex => $section)
            <div class="card mb-5">
                <div class="card-header bg-light-success">
                    <h3>{{ $section['title'] }}</h3>
                </div>
                <div class="card-body">
                    @foreach($section['questions'] as $qIndex => $question)
                        <div class="mb-4">
                            <h5>{{ $question['text'] }}</h5>
                            <canvas id="chart-{{ $sIndex }}-{{ $qIndex }}" height="100"></canvas>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $sections->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let chartData = @json($chartData);

            chartData.forEach((section, sIndex) => {
                section.questions.forEach((question, qIndex) => {
                    let ctx = document.getElementById(`chart-${sIndex}-${qIndex}`).getContext('2d');

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: question.labels,
                            datasets: [{
                                label: question.text,
                                data: question.data,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: question.text,
                                    font: { size: 16 }
                                }
                            },
                            scales: {
                                y: { beginAtZero: true, ticks: { precision: 0 } }
                            }
                        }
                    });
                });
            });
        });
    </script>

</x-app-layout-admin>
