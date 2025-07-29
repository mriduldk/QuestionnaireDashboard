<x-app-layout-admin>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Districts</h3>
            <a href="{{ route('districts.create') }}" class="btn btn-success">+ Add District</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>District Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($districts as $district)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $district->name }}</td>
                        <td>
                            <a href="{{ route('districts.edit', $district) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('districts.destroy', $district) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($districts->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center">No districts found.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout-admin>
