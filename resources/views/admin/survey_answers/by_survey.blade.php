<x-app-layout-admin>
    <h2 class="mb-3">Survey: {{ $survey->title }}</h2>

    <form method="GET" class="row g-3 mb-4">
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
            <select name="subDivision" class="form-control">
                <option value="">-- Select Sub Division --</option>
                <option value="">All</option>
                @foreach ($subDivisions as $subDivision)
                    <option value="{{ $subDivision }}" {{ request('constituency') == $subDivision ? 'selected' : '' }}>{{ $subDivision }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="vcdc" class="form-control">
                <option value="">-- Select VCDC --</option>
                <option value="">All</option>
                @foreach ($vcdcs as $vcdc)
                    <option value="{{ $vcdc }}" {{ request('vcdc') == $vcdc ? 'selected' : '' }}>{{ $vcdc }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
        </div>
    </form>


    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-sm" id="kt_datatables">
                <thead>
                    <tr>
                        {{--<th>Name</th>
                        <th>Phone</th>--}}
                        <th>District</th>
                        <th>Sub Division</th>
                        <th>VCDC</th>
                        <th>Block</th>
                        <th>Address</th>
                        <th>Surveyed By</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($answers as $ans)
                    <tr>
                        {{--<td>{{ $ans->name }}</td>
                        <td>{{ $ans->phone_number }}</td>--}}
                        <td>{{ $ans->district }}</td>
                        <td>{{ $ans->sub_division ?? '-' }}</td>
                        <td>{{ $ans->vcdc }}</td>
                        <td>{{ $ans->block }}</td>
                        <td>{{ $ans->village }}</td>
                        <td>{{ $ans->user?->name ?? 'N/A' }}<br>{{ $ans->updated_at?->format('d-m-Y h:i A') }}</td>
                        <td>
                            @if (strtolower($ans->status) === 'draft')
                                <span class="badge bg-warning text-dark">Draft</span>
                            @elseif (strtolower($ans->status) === 'completed')
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($ans->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('survey-answers.show', $ans->survey_answer_id) }}" class="btn btn-sm btn-info">
                                View
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">No answers found.</td></tr>
                @endforelse
                </tbody>
            </table>

            {{--<div class="mt-3">
                {{ $answers->appends(request()->query())->links() }}
            </div>--}}
        </div>
    </div>
</x-app-layout-admin>
