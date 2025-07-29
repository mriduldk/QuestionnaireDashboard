<x-app-layout-admin>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Sub-Divisions</h3>
            <a href="{{ route('sub-divisions.create') }}" class="btn btn-success">+ Add Sub-Division</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Sub-Division Name</th>
                    <th>District</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subDivisions as $subDivision)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $subDivision->name }}</td>
                        <td>{{ $subDivision->district->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('sub-divisions.edit', $subDivision) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('sub-divisions.destroy', $subDivision) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($subDivisions->isEmpty())
                    <tr><td colspan="4" class="text-center">No Sub-Divisions found.</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout-admin>
