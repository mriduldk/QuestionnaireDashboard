@if ($questions->count())
    <ul class="list-group">
        @foreach ($questions as $question)
            @include('admin.questions.partials._question', ['question' => $question])
        @endforeach
    </ul>
@else
    <p class="text-muted">No questions found for this section.</p>
@endif
