<x-app-layout-admin>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2 class="card-label">User List</h2>
            <a href="{{ route('users.create') }}" class="btn btn-primary float-end">+ Add User</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="kt_datatables">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->phone }}</td>
                        <td>{{ $u->is_active ? 'Yes' : 'No' }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $u->user_id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('users.edit', $u) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
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
