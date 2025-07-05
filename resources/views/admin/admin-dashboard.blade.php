<x-app-layout-admin>

    <div class="row">
        <!-- Total Surveys Submitted -->
        <div class="col-md-4">
            <div class="card card-custom bg-primary text-white">
                <div class="card-body text-center">
                    <h5>Total Surveys Submitted</h5>
                    <h2>{{ $totalSurveys }}</h2>
                </div>
            </div>
        </div>

        <!-- Surveys by Status -->
        <div class="col-md-4">
            <div class="card card-custom bg-info text-white">
                <div class="card-body text-center">
                    <h5>Completed</h5>
                    <h2>{{ $completedCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom bg-warning text-white">
                <div class="card-body text-center">
                    <h5>Draft</h5>
                    <h2>{{ $draftCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-5 mt-4">
        <div class="card-header"><h3 class="card-title">Demographics Report</h3></div>
        <div class="card-body row">
            <div class="col-md-4">
                <h5>Gender Distribution</h5>
                <div style="max-width: 250px; margin: auto;">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <h5>Age Group Distribution</h5>
                <canvas id="ageChart"></canvas>
            </div>
            <div class="col-md-4">
                <h5>Caste Breakdown</h5>
                <canvas id="casteChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Submission Trend Chart -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Submissions Over Time</h3>
                </div>
                <div class="card-body">
                    <canvas id="submissionTrendChart"></canvas>
                </div>
            </div>
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



    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const genderCtx = document.getElementById('genderChart').getContext('2d');
            const ageCtx = document.getElementById('ageChart').getContext('2d');
            const casteCtx = document.getElementById('casteChart').getContext('2d');

            new Chart(genderCtx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($genderCounts->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($genderCounts->values()) !!},
                        backgroundColor: ['#4e73df', '#e74a3b', '#f6c23e'],
                    }],
                },
            });

            new Chart(ageCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($ageCounts)) !!},
                    datasets: [{
                        label: 'Count',
                        data: {!! json_encode(array_values($ageCounts)) !!},
                        backgroundColor: '#36b9cc',
                    }],
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            new Chart(casteCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($casteCounts->keys()) !!},
                    datasets: [{
                        label: 'Count',
                        data: {!! json_encode($casteCounts->values()) !!},
                        backgroundColor: '#1cc88a',
                    }],
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        </script>
    @endpush


</x-app-layout-admin>
