<x-app-layout-admin>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="bg-white p-4 shadow rounded mb-6">
        <canvas id="trendChart" height="100"></canvas>
    </div>

    <div class="bg-white p-4 shadow rounded mb-6">
        <canvas id="districtChart"></canvas>
    </div>

    <div class="bg-white p-4 shadow rounded mb-6">
        <canvas id="districtTrendChart"></canvas>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-label">User List</h2>

            <div class="card-toolbar d-flex">
                <form method="GET" action="{{ route('surveys.userListBySurvey', $id) }}" class="form-inline">
                    <select id="performanceFilter" name="performance" class="form-control mr-2">
                        <option value="">-- Filter Performance --</option>
                        <option value="high" {{ request('performance')=='high' ? 'selected' : '' }}>Good (Above 80%)</option>
                        <option value="medium" {{ request('performance')=='medium' ? 'selected' : '' }}>Average (50% - 80%)</option>
                        <option value="low" {{ request('performance')=='low' ? 'selected' : '' }}>Below Average (Below 50%)</option>
                        <option value="zero" {{ request('performance')=='zero' ? 'selected' : '' }}>0 Answers</option>
                    </select>

                    <select id="districtFilter" name="district" class="form-control mr-2">
                        <option value="">-- Filter District --</option>
                        @foreach($districts as $districtId => $districtName)
                            <option value="{{ $districtId }}" {{ request('district') == $districtId ? 'selected' : '' }}>
                                {{ $districtName }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="kt_datatables">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Father's Name</th>
                    <th>Address</th>
                    <th>District</th>
                    <th>Photo</th>
                    <th>Survey</th>
                    <th>Survey Answer Count</th>
                    <th>Performance %</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}<br>{{ $u->phone }}</td>

                        <td>{{ $u->father_name }}</td>
                        <td>{{ $u->village }} {{ $u->address }}</td>
                        <td>{{ $u->districtInfo->name ?? '' }}</td>
                        <td>
                            @if($u->photo)
                                <img src="{{ asset($u->photo) }}" height="50">
                            @endif
                        </td>
                        <td>{{ $u->survey->title ?? 'N/A' }}</td>
                        <td>
                            <p>
                                <span class="badge badge-light font-size-h5 font-weight-bolder rounded-pill">
                                {{ $u->survey_answers_count }} Answers
                            </span>
                            </p>
                        </td>
                        <td>
                            <span class="badge font-size-h6 font-weight-bolder bg-{{ $u->performance >= 80 ? 'success' : ($u->performance >= 50 ? 'warning' : 'danger') }}">
                                {{ $u->performance }}%
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('admin.users.show', $u->user_id) }}" class="btn btn-sm btn-info btn-block mb-1">View Details</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('trendChart').getContext('2d');

        const trendData = @json($trendBySurvey);

        const datasets = Object.keys(trendData).map((surveyId, index) => {
            return {
                label: "Survey " + trendData[surveyId].name,
                data: trendData[surveyId].data,
                borderColor: getRandomColor(),
                backgroundColor: getRandomColor(0.2),
                fill: false,
            };
        });

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: trendData[Object.keys(trendData)[0]].labels, // first survey's labels
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Daily Count - Survey Wise',
                        font: {
                            size: 20,
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });

        function getRandomColor(alpha = 1) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            //return `rgba(${r}, ${g}, ${b}, ${alpha})`;
            return `rgba(10, 160, 220, 1)`;
        }


        const districtCtx = document.getElementById('districtChart').getContext('2d');
        const districtData = @json($districtChartData);

        new Chart(districtCtx, {
            type: 'bar',
            data: {
                labels: districtData.labels,
                datasets: [{
                    label: 'Total Surveys',
                    data: districtData.data,
                    backgroundColor: getRandomColor2(0.5),
                    borderColor: getRandomColor2(),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'District-wise Survey Counts',
                        font: { size: 20, weight: 'bold' }
                    }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });

        function getRandomColor2(alpha = 1) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            //return `rgba(${r}, ${g}, ${b}, ${alpha})`;
            return `rgba(10, 160, 220, 1)`;
        }


    </script>

    <script>
        const districtTrendData = @json($districtTrendChart);

        // Collect all unique dates across all districts
        let allDates = [];
        districtTrendData.forEach(d => {
            allDates = [...new Set([...allDates, ...d.labels])];
        });
        allDates.sort(); // ensure chronological order

        const fixedColors = [
            'rgba(54, 162, 235, 0.9)',  // Blue
            'rgba(255, 99, 132, 0.9)',  // Red
            'rgba(75, 192, 192, 0.9)',  // Teal
            'rgba(255, 206, 86, 0.9)',  // Yellow
            'rgba(153, 102, 255, 0.9)'  // Purple
        ];

        // Build datasets
        const datasets3 = districtTrendData.map((d, idx) => {
            // Fill missing dates with 0
            const data = allDates.map(date => {
                const index = d.labels.indexOf(date);
                return index !== -1 ? d.data[index] : 0;
            });

            return {
                label: d.name,
                data: data,
                fill: false,
                borderColor: fixedColors[idx % fixedColors.length],  // cycle colors
                backgroundColor: fixedColors[idx % fixedColors.length],
                tension: 0.3
            };
        });

        const ctx3 = document.getElementById('districtTrendChart').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: allDates,
                datasets: datasets3
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Daily Submissions by District'
                    }
                },
                scales: {
                    x: { title: { display: true, text: 'Date' } },
                    y: { title: { display: true, text: 'Count' }, beginAtZero: true }
                }
            }
        });

        // Your earlier light blue generator
        function getRandomLightBlue(alpha = 1) {
            const r = Math.floor(Math.random() * 100);
            const g = Math.floor(150 + Math.random() * 105);
            const b = Math.floor(200 + Math.random() * 55);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }



    </script>

</x-app-layout-admin>
