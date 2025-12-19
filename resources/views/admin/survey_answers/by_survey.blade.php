<x-app-layout-admin>
    <h2 class="mb-3">Survey: {{ $survey->title }}</h2>

    <form method="GET" class="row g-3 mb-4" hidden>
        <div class="col-md-3">
            <select name="district" class="form-control">
                <option value="">-- Select District --</option>
                <option value="">All</option>
                @foreach ($districts as $dist)
                    <option value="{{ $dist }}" {{ request('district') == $dist ? 'selected' : '' }}>{{ $dist }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
        </div>
    </form>


    <div class="card">
        <div class="card-body">
     
            <table class="table table-bordered table-sm" id="ktsdatatables">
            @php
                //dd($answers);
                // Collect all unique header labels across all answers
                $allHeaders = collect($answers->items())
                    ->flatMap(fn($ans) => collect($ans->form_specs ?? [])
                        ->flatMap(fn($section) => $section['components'] ?? [])
                        ->where('header', true)
                        ->pluck('label')
                    )
                    ->unique()
                    ->values();
            @endphp

            <thead>
                <tr>
                    @foreach($allHeaders as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                    <th>Submitted On</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($answers as $ans)
                    @php
                        // Extract only header:true fields for this row
                        $headers = collect($ans->form_specs ?? [])
                            ->flatMap(fn($section) => $section['components'] ?? [])
                            ->where('header', true)
                            ->mapWithKeys(fn($c) => [
                                $c['label'] ?? 'Unknown' => $c['answer'] ?? null
                            ])
                            ->toArray();
                    @endphp

                    <tr>
                        @foreach($allHeaders as $header)
                            <td>{{ $headers[$header] ?? '-' }}</td>
                        @endforeach
                        <td>{{ $ans->created_at?->format('d-m-Y h:i A') }}</td>
                        <td>
                            <a href="{{ route('survey-answers.show', $ans->survey_answer_id) }}"
                            class="btn btn-sm btn-info">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $allHeaders->count() + 1 }}" class="text-center">No answers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $answers->links('pagination::bootstrap-5') }}
        </div>

        </div>
    </div>

    <script>
        // disable datatables buttons
        

        $(document).ready(function() {
            $('#ktsdatatables').DataTable({
                responsive: true,
                pagingType: 'full_numbers',
                order: [],
                dom: '<"float-left"l><"float-right"f>rt<"row"<"col-sm-4"><"col-sm-4"><"col-sm-4">>',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    ['10 rows', '25 rows', '50 rows', '100 rows', 'Show all']
                ]
            });
        });

    </script>

</x-app-layout-admin>
