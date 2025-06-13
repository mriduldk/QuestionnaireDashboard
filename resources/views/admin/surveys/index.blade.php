<x-app-layout-admin>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2 class="card-label">Survey List</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="kt_datatables">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($surveys as $survey)
                    <tr>
                        <td><a href="{{ url('/admin/surveys/' . $survey->id) }}">{{ $survey->title }}</a></td>
                        <td>{{ $survey->description }}</td>
                        <td>
                            <a href="{{ route('surveys.edit', $survey->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('surveys.destroy', $survey->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout-admin>
