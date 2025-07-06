<x-app-layout-admin>

<div class="container">
    <h2>{{ $survey->title }}</h2>
    <p>{{ $survey->description }}</p>

    {{-- <div class="mb-3">
        <a href="{{ url('/admin/sections/create?survey_id=' . $survey->id) }}" class="btn btn-primary">
            + Add Section
        </a>
    </div> --}}

    {{-- <h5>Sections</h5>
    @foreach($survey->sections as $section)
        <div class="card my-2">
            <div class="card-header">{{ $section->title }}</div>
            <div class="card-body">
                @foreach($section->questions as $q)
                    <p><strong>Q:</strong> {{ $q->question_text }} ({{ $q->type }})</p>
                @endforeach
            </div>
        </div>
    @endforeach --}}

    <h5>Sections</h5>
    {{--@foreach($survey->sections as $section)
        <div class="card my-3">
            <div class="card-header"><strong>{{ $section->title }}</strong></div>
            <div class="card-body">
                @foreach($section->questions->where('parent_id', null) as $q)
                    <div class="mb-2">
                        <span><strong>Q {{ $q->id }}:</strong> {{ $q->question_text }} ({{ $q->type }})</span></br>

                        --}}{{-- Show options if any --}}{{--
                        @if(in_array($q->type, ['radio', 'checkbox', 'select']) && isset($q->metadata['options']))
                            <ul>
                                @foreach($q->metadata['options'] as $option)
                                    <li>{{ $option }}</li>
                                @endforeach
                            </ul>
                        @endif

                        --}}{{-- Show sub-questions --}}{{--
                        @foreach($section->questions->where('parent_id', $q->id) as $sub)
                            <div class="ml-4 mb-2">
                                <span><strong>→ Sub-Q {{$sub->id}}:</strong> {{ $sub->question_text }} ({{ $sub->type }})</span></br>

                                --}}{{-- Conditional logic preview --}}{{--
                                @if ($sub->conditional_logic)
                                    <small class="text-muted">
                                        <em>Shown if Q{{ $sub->conditional_logic['show_if']['question_id'] }}
                                        {{ $sub->conditional_logic['show_if']['operator'] }}
                                        "{{ $sub->conditional_logic['show_if']['value'] }}"</em>
                                    </small>
                                @endif

                                --}}{{-- Show options if any --}}{{--
                                @if(in_array($sub->type, ['radio', 'checkbox', 'select']) && isset($sub->metadata['options']))
                                    <ul>
                                        @foreach($sub->metadata['options'] as $option)
                                            <li>{{ $option }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach--}}

    <h5>Sections</h5>
    @foreach($survey->sections as $section)
        <div class="card my-3">
            <div class="card-header"><strong>{{ $section->title }}</strong></div>
            <div class="card-body">
                @foreach($section->questions->where('parent_id', null) as $q)
                    @include('admin.surveys._question', ['question' => $q])
                @endforeach
            </div>
        </div>
    @endforeach



</div>

</x-app-layout-admin>
