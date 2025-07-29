<x-app-layout-admin>
    <div class="card">
        <div class="card-header"><h3>Edit Sub-Division</h3></div>

        <form method="POST" action="{{ route('sub-divisions.update', $subDivision) }}">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="form-group">
                    <label>District</label>
                    <select name="district_id" class="form-control" required>
                        <option value="">-- Select District --</option>
                        @foreach($districts as $id => $name)
                            <option value="{{ $id }}" {{ $subDivision->district_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('district_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Sub-Division Name</label>
                    <input type="text" name="name" value="{{ old('name', $subDivision->name) }}" class="form-control" required>
                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('sub-divisions.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</x-app-layout-admin>
