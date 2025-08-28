<x-app-layout-admin>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Survey Reports</h2>

        {{-- Survey-wise Trend --}}
        <div class="bg-white p-4 shadow rounded mb-6">
            <h3 class="font-semibold text-lg mb-3">Survey-wise Trends</h3>
            <canvas id="trendChart" height="100"></canvas>
        </div>

        {{-- District Counts Survey-wise --}}
        <div class="bg-white p-4 shadow rounded">
            <h3 class="font-semibold text-lg mb-3">District-wise Counts (per Survey)</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                @foreach($districtCounts as $surveyId => $rows)
                    <div class="bg-gray-50 p-3 rounded shadow">
                        <h4 class="font-semibold text-md mb-2">Survey ID: {{ \App\Models\Survey::find($surveyId)?->title ?? $surveyId }}</h4>
                        <table class="w-full table-auto border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-2 py-1">District</th>
                                    <th class="border px-2 py-1">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $row)
                                    <tr>
                                        <td class="border px-2 py-1">{{ $row->district }}</td>
                                        <td class="border px-2 py-1">{{ $row->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

            </div>
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
            }
        });

        function getRandomColor(alpha = 1) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }
    </script>
</x-app-layout-admin>
