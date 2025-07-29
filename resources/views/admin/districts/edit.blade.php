<x-app-layout-admin>
    <div class="card">
        <div class="card-header"><h3>Edit District</h3></div>

        <form method="POST" action="{{ route('districts.update', $district) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>District Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $district->name) }}" required>
                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('districts.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</x-app-layout-admin>
