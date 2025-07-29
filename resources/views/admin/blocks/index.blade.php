<x-app-layout-admin>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Blocks</h3>
            <a href="{{ route('blocks.create') }}" class="btn btn-success">+ Add Block</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Block Name</th>
                    <th>Sub-Division</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($blocks as $block)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $block->name }}</td>
                        <td>{{ $block->subDivision->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('blocks.edit', $block) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('blocks.destroy', $block) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($blocks->isEmpty())
                    <tr><td colspan="4" class="text-center">No Blocks found.</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout-admin>
