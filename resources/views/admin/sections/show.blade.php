<x-app-layout-admin>
<div class="container">
    <h3>Section: {{ $section->title }}</h3>
    <p>Order: {{ $section->order }}</p>
    <h5>Questions</h5>
    <ul>
        @foreach($section->questions as $question)
            <li>{{ $question->question_text }} ({{ $question->type }})</li>
        @endforeach
    </ul>
</div>
</x-app-layout-admin>
