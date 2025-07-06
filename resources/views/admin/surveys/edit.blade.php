<x-app-layout-admin>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2 class="card-label">Edit Survey</h2>
        </div>

        <form action="{{ route('surveys.update', $survey->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title', $survey->title) }}">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control">{{ old('description', $survey->description) }}</textarea>
                </div>

                <div class="form-check mt-2">
                    <input type="checkbox" name="status" value="1" class="form-check-input" id="statusCheck"
                        {{ old('status', $survey->status) ? 'checked' : '' }}>
                    <label class="form-check-label" for="statusCheck">Active</label>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('surveys.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

</x-app-layout-admin>
