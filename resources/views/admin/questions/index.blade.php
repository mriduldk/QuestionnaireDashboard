<x-app-layout-admin>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2 class="card-label">Question List</h2>
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
        </div>
    </div>

</x-app-layout-admin>
