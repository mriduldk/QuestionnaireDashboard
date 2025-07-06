<x-app-layout-admin>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h2 class="card-label mb-0">Section List</h2>

            <form method="GET" action="{{ route('sections.index') }}" class="form-inline">
                <select name="survey_id" onchange="this.form.submit()" class="form-control" style="min-width: 250px;">
                    <option value="">-- Filter by Survey --</option>
                    @foreach($surveys as $survey)
                        <option value="{{ $survey->id }}" {{ request('survey_id') == $survey->id ? 'selected' : '' }}>
                            {{ $survey->title }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>


        <div class="card-body">
            <table class="table table-bordered" id="kt_datatables">
                <thead>
                    <tr>
                        <th>Survey</th>
                        <th>Title</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sections as $section)
                        <tr>
                            <td>{{ $section->survey->title }}</td>
                            <td>{{ $section->title }}</td>
                            <td>{{ $section->order }}</td>
                            <td>
                                <a href="{{ route('sections.show', $section) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('sections.edit', $section) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('sections.destroy', $section) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

</x-app-layout-admin>
