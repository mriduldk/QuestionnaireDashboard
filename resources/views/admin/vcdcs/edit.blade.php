<x-app-layout-admin>
    <div class="card">
        <div class="card-header"><h3>Edit VCDC</h3></div>

        <form method="POST" action="{{ route('vcdcs.update', $vcdc) }}">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="form-group">
                    <label>Block</label>
                    <select name="block_id" class="form-control" required>
                        <option value="">-- Select Block --</option>
                        @foreach($blocks as $id => $name)
                            <option value="{{ $id }}" {{ (old('block_id', $vcdc->block_id) == $id) ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('block_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>VCDC Name</label>
                    <input type="text" name="name" value="{{ old('name', $vcdc->name) }}" class="form-control" required>
                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

            </div>
            <div class="card-footer">
                <button class="btn btn-success">Update</button>
                <a href="{{ route('vcdcs.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</x-app-layout-admin>
