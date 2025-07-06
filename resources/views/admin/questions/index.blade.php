<x-app-layout-admin>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-label mb-0">All Question List</h2>

            <form method="GET" action="{{ route('questions.index') }}" class="d-flex gap-2" id="filterForm">
                <select name="survey_id" id="survey_id" class="form-control mr-4" style="width: 300px;" onchange="document.getElementById('filterForm').submit()">
                    <option value="">-- Select Survey --</option>
                    @foreach ($surveys as $survey)
                        <option value="{{ $survey->id }}" {{ request('survey_id') == $survey->id ? 'selected' : '' }}>
                            {{ $survey->title }}
                        </option>
                    @endforeach
                </select>

                <select name="section_id" id="section_id" class="form-control" style="width: 300px;" onchange="document.getElementById('filterForm').submit()">
                    <option value="">-- Select Section --</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                            {{ $section->title }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>


        <div class="card-body">
            <table class="table table-bordered" id="kt_datatables">
                <thead>
                    <tr>
                        <th>Section</th>
                        <th>Text</th>
                        <th>Type</th>
                        <th>Required</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $q)
                        <tr>
                            <td>{{ $q->section->title }}</td>
                            <td>{{ $q->question_text }}</td>
                            <td>{{ $q->type }}</td>
                            <td>{{ $q->is_required ? 'Yes' : 'No' }}</td>
                            <td>
                                <a href="{{ route('questions.edit', $q) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('questions.destroy', $q) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this question?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{--<div class="mt-3">
                {{ $questions->appends(request()->query())->links() }}
            </div>--}}


        </div>
    </div>

</x-app-layout-admin>
