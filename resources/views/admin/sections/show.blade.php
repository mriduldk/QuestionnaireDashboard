<x-app-layout-admin>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-label mb-0">Section Details</h3>
            <a href="{{ route('questions.create') }}?section_id={{ $section->id }}" class="btn btn-sm btn-success">+ Add Question</a>
        </div>

        <div class="card-body">
            <div class="mb-3"><strong>Survey:</strong> {{ $section->survey->title }}</div>
            <div class="mb-3"><strong>Section Title:</strong> {{ $section->title }}</div>
            <div class="mb-3"><strong>Order:</strong> {{ $section->order }}</div>

            <hr>
            <h5>Questions</h5>

            @if ($section->questions->whereNull('parent_id')->count())
                <ul class="list-group">
                    @foreach($section->questions->where('parent_id', null) as $q)
                        @include('admin.questions.partials._question', ['question' => $q])
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No questions added to this section yet.</p>
            @endif
        </div>
    </div>

</x-app-layout-admin>
