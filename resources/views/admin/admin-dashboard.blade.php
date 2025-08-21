<x-app-layout-admin>

    <div class="row">
        <!-- Total Surveys Submitted -->
        <div class="col-md-6">
            <div class="card card-custom bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Surveys Submitted</h5>
                    <h2>{{ $totalSurveys }}</h2>
                </div>
            </div>
        </div>

        <!-- Surveys by Status -->
        <div class="col-md-6">
            <div class="card card-custom bg-info text-white">
                <div class="card-body text-center">
                    <h5>Surveys Submitted Today</h5>
                    <h2>{{ $todaySurveyCount }}</h2>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-4">
            <div class="card card-custom bg-warning text-white">
                <div class="card-body text-center">
                    <h5>Draft</h5>
                    <h2>{{ $draftCount }}</h2>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Submission Trend Chart -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Submissions Over Time</h3>
                </div>
                <div class="card-body">
                    <canvas id="submissionTrendChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h2 class="card-label">Surveys by District</h2>
        </div>
        <div class="card-body">
            <canvas id="districtChart" height="80"></canvas>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('submissionTrendChart').getContext('2d');
            const submissionTrendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($trendLabels) !!},
                    datasets: [{
                        label: 'Surveys Submitted',
                        data: {!! json_encode($trendData) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });
        </script>
    @endpush

    <canvas id="districtChart"></canvas>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx2 = document.getElementById('districtChart').getContext('2d');
        const districtChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: {!! json_encode($districtCounts->pluck('district')) !!},
                datasets: [{
                    label: 'Survey Count',
                    data: {!! json_encode($districtCounts->pluck('total')) !!},
                    backgroundColor: '#36A2EB',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
    @endpush



</x-app-layout-admin>
