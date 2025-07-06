@php
    $indent = $indent ?? 0;
    $padding = $indent * 20; // adjust for visual nesting
@endphp

<div class="mb-2" style="padding-left: {{ $padding }}px;">
    <span>
        <strong>{{ $indent > 0 ? '→ Sub-Q' : 'Q' }} {{ $question->id }}:</strong>
        {{ $question->question_text }} ({{ $question->type }})
    </span><br>

    {{-- Conditional logic --}}
    @if (isset($question->conditional_logic))
        <small class="text-muted">
            <em>Shown if Q{{ $question->conditional_logic['show_if']['question_id'] }}
                {{ $question->conditional_logic['show_if']['operator'] }}
                "{{ $question->conditional_logic['show_if']['value'] }}"</em>
        </small><br>
    @endif

    {{-- Options --}}
    @if(in_array($question->type, ['radio', 'checkbox', 'select']) && isset($question->metadata['options']))
        <ul>
            @foreach($question->metadata['options'] as $option)
                <li>{{ $option }}</li>
            @endforeach
        </ul>
    @endif

    {{-- Recursive sub-questions --}}
    @foreach($question->subQuestions as $child)
        @include('admin.surveys._question', ['question' => $child, 'indent' => $indent + 1])
    @endforeach
</div>
