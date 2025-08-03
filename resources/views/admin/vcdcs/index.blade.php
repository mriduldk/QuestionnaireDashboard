<x-app-layout-admin>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">VCDC List</h3>
            <a href="{{ route('vcdcs.create') }}" class="btn btn-primary">Add VCDC</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>VCDC Name</th>
                    <th>District</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($vcdcs as $vcdc)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $vcdc->name }}</td>
                        <td>{{ $vcdc->district->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('vcdcs.edit', $vcdc) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('vcdcs.destroy', $vcdc) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No VCDC found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout-admin>
