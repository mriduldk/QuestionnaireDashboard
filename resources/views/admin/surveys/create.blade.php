
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


    <div class="card">
        <div class="card-header">
            <h2 class="card-label">Add Survey</h2>
        </div>

        <form action="{{ route('surveys.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
               
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
    

{{-- <div class="container">
    <h2>Create Survey</h2>
    <form method="POST" action="{{ url('/admin/surveys') }}">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input name="title" class="form-control" required />
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-check">
            <input type="checkbox" name="status" class="form-check-input" checked />
            <label class="form-check-label">Active</label>
        </div>
        <button type="submit" class="btn btn-success mt-3">Create</button>
    </form>
</div> --}}

</x-app-layout-admin>