
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
            <h2 class="card-label">Edit Question</h2>
        </div>

        <form method="POST" action="{{ route('questions.update', $question) }}">
            @csrf @method('PUT')
            <div class="card-body">

                <div class="form-group">
                    <label>Section</label>
                    <select name="section_id" class="form-control" required>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" {{ $question->section_id == $section->id ? 'selected' : '' }}>
                                {{ $section->survey->title }} - {{ $section->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Question Text</label>
                    <input type="text" name="question_text" class="form-control" required value="{{ $question->question_text }}">
                </div>

                <div class="form-group">
                    <label>Type</label>
                    <select name="type" class="form-control" required>
                        @foreach(['text', 'number', 'radio', 'checkbox', 'select', 'textarea'] as $type)
                            <option value="{{ $type }}" {{ $question->type == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Is Required?</label>
                    <input type="checkbox" name="is_required" value="1" {{ $question->is_required ? 'checked' : '' }}>
                </div>

                <div class="form-group">
                    <label>Metadata (JSON)</label>
                    <textarea name="metadata" class="form-control" rows="3">{{ json_encode($question->metadata) }}</textarea>
                </div>

                <button class="btn btn-primary">Update Question</button>

            </div>
        </form>

</div>

</x-app-layout-admin>
