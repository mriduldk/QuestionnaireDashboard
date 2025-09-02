<x-app-layout-admin>
    <div class="p-6">
        <h2 class="text-xl font-bold mb-4">Survey Reports</h2>

        {{-- Survey-wise Trend --}}
        <div class="bg-white p-4 shadow rounded mb-6">
            <canvas id="trendChart" height="100"></canvas>
        </div>

        <div class="bg-white p-4 shadow rounded mb-6">
            <canvas id="districtChart"></canvas>
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

        // Union of all district labels from all surveys
        const allLabels = [...new Set([].concat(...Object.values(districtData).map(d => d.labels)))];

        // Build datasets: align data with allLabels
        const datasets2 = Object.keys(districtData).map((surveyId) => {
            const survey = districtData[surveyId];
            const data = allLabels.map(label => {
                const idx = survey.labels.indexOf(label);
                return idx !== -1 ? survey.data[idx] : 0; // fill 0 if district not present
            });

            return {
                label: survey.name,
                data: data,
                backgroundColor: getRandomColor(0.5),
                borderColor: getRandomColor(),
                borderWidth: 1
            };
        });

        new Chart(districtCtx, {
            type: 'bar',
            data: {
                labels: allLabels,
                datasets: datasets2
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'District-wise Counts per Survey',
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

        function getRandomColor2(alpha = 1) {
            const r = Math.floor(Math.random() * 255);
            const g = Math.floor(Math.random() * 255);
            const b = Math.floor(Math.random() * 255);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }



    </script>

</x-app-layout-admin>
