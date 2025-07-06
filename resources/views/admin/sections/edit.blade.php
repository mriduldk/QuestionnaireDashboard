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
            <h2 class="card-label">Edit Section</h2>
        </div>

        <form method="POST" action="{{ route('sections.update', $section) }}">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">
                    <label>Survey:</label>
                    <select name="survey_id" class="form-control" required>
                        <option value="">Select a Survey</option>
                        @foreach ($surveys as $id => $title)
                            <option value="{{ $id }}" {{ $section->survey_id == $id ? 'selected' : '' }}>
                                {{ $title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Section Title:</label>
                    <input type="text" name="title" value="{{ $section->title }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Order</label>
                    <input type="number" name="order" value="{{ $section->order }}" class="form-control" required />
                </div>

            </div>

            <div class="card-footer">
                <button class="btn btn-primary">Update Section</button>
            </div>
        </form>
    </div>

</x-app-layout-admin>
