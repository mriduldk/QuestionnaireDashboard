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

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-label">User List</h2>

            <div class="card-toolbar d-flex">
                <form method="GET" action="{{ route('surveys.userListBySurvey', $id) }}" class="form-inline">
                    <select id="performanceFilter" name="performance" class="form-control mr-2">
                        <option value="">-- Filter Performance --</option>
                        <option value="zero" {{ request('performance')=='zero' ? 'selected' : '' }}>0 Answers</option>
                        <option value="low" {{ request('performance')=='low' ? 'selected' : '' }}>Below 50%</option>
                        <option value="medium" {{ request('performance')=='medium' ? 'selected' : '' }}>50% - 80%</option>
                        <option value="high" {{ request('performance')=='high' ? 'selected' : '' }}>Above 80%</option>
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

                        {{--<td>
                            @php
                                if ($u->survey_id == 17){
                                    $startDate = \Carbon\Carbon::create(2025, 8, 20);
                                } else if ($u->survey_id == 21){
                                    $startDate = \Carbon\Carbon::create(2025, 8, 26);
                                } else if ($u->survey_id == 22){
                                    $startDate = \Carbon\Carbon::create(2025, 9, 1);
                                } else {
                                    $startDate = \Carbon\Carbon::create(2025, 9, 1);
                                }
                                $today = \Carbon\Carbon::today();
                                $totalDays = $startDate->diffInDays($today) + 1; // include today
                                $expectedAnswers = $totalDays * 5;
                                $performance = ($expectedAnswers > 0)
                                    ? round(($u->survey_answers_count / $expectedAnswers) * 100, 2)
                                    : 0;
                            @endphp

                            <span class="badge font-size-h6 font-weight-bolder bg-{{ $performance >= 80 ? 'success' : ($performance >= 50 ? 'warning' : 'danger') }}">
                                {{ $performance }}%
                            </span>
                        </td>--}}

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
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
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
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }



    </script>


</x-app-layout-admin>
