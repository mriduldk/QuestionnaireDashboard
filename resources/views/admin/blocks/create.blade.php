<x-app-layout-admin>
    <div class="card">
        <div class="card-header"><h3>Add Block</h3></div>

        <form method="POST" action="{{ route('blocks.store') }}">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label>Sub-Division</label>
                    <select name="sub_division_id" class="form-control" required>
                        <option value="">-- Select Sub-Division --</option>
                        @foreach($subDivisions as $id => $name)
                            <option value="{{ $id }}" {{ old('sub_division_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('sub_division_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Block Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

            </div>
            <div class="card-footer">
                <button class="btn btn-success">Save</button>
                <a href="{{ route('blocks.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</x-app-layout-admin>
