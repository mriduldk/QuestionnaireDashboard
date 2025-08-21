<x-app-layout-admin>

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-start">
            <div>
                <h2 class="card-label mb-1">Survey Answer Details</h2>
                <a href="{{ route('survey-answers.export', $surveyAnswer->survey_answer_id) }}" class="btn btn-sm btn-success">
                    Download as Excel
                </a>

                <a href="{{ route('survey-answers.index') }}" class="btn btn-sm btn-secondary mt-1">Back</a>
            </div>

            @if ($surveyAnswer->user)
                <div class="text-end text-dark">
                    <div class="fw-semibold fs-6">
                        <span class="text-muted">Created By:</span>
                        <a href="{{ route('admin.users.show', $surveyAnswer->user->user_id) }}" class="fw-bold text-primary text-decoration-none">
                            {{ $surveyAnswer->user->name ?? 'N/A' }}
                        </a>
                    </div>
                    @if ($surveyAnswer->user->email)
                        <div class="fs-6">
                            <span class="text-muted">Email:</span>
                            <span class="fw-medium text-dark">{{ $surveyAnswer->user->email }}</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="card-body">

            @php
                $headers = collect($surveyAnswer->form_specs ?? [])
                    ->flatMap(fn($section) => $section['components'] ?? [])
                    ->where('header', true)
                    ->mapWithKeys(fn($c) => [
                        $c['label'] ?? 'Unknown' => $c['answer'] ?? null
                    ])
                    ->toArray();
            @endphp

            <table class="table table-bordered">
                <tbody>
                    @foreach($headers as $label => $answer)
                        <tr>
                            <th style="width: 30%">{{ $label }}</th>
                            <td>{{ $answer ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>



            {{-- <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>Responder's Name</th><td>{{ $surveyAnswer->name }}</td>
                    <th>Responder's Phone</th><td>{{ $surveyAnswer->phone_number }}</td>
                    <th>Responder's Age</th><td>{{ $surveyAnswer->age }}</td>
                </tr>
                <tr>
                    <th>Responder's Gender</th><td>{{ ucfirst($surveyAnswer->gender) }}</td>
                    <th>Responder's Caste</th><td>{{ $surveyAnswer->caste }}</td>
                </tr>
                <tr>
                    <th>District</th><td>{{ $surveyAnswer->district }}</td>
                    <th>VCDC</th>
                    <td>{{ $surveyAnswer->vcdc }}</td>
                    <th>Village</th>
                    <td>{{ $surveyAnswer->village }}</td>
                </tr>

                <tr>
                    <th>Last Updated At</th>
                    <td>{{ $surveyAnswer->updated_at ? $surveyAnswer->updated_at->format('d-m-Y h:i A') : 'N/A' }}</td>
                </tr>
                </tbody>
            </table> --}}

        
            @if ($survey)
                <div class="card mb-4">
                    <div class="card-header h4 bg-primary text-white">
                        <strong>Survey:</strong> {{ $survey->title }}
                    </div>
                    <div class="card-body">
                        @foreach ($survey->sections as $section)
                            <div class="mb-8">

                                <h5 class="text-info font-size-h4 font-weight-bolder">Section: {{ $section->title }}</h5>

                                <table class="table table-sm table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 40%;" class="font-size-h5">Question</th>
                                        <th style="width: 60%;" class="font-size-h5">Answer</th>
                                    </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach ($section->questions as $question)
                                            <tr>
                                                <td>{{ $question->question_text }}</td>
                                                <td>
                                                    {{-- ✅ Check for multiple answers first --}}
                                                    @if (isset($multipleQuestionAnswers[$question->id]))

                                                        {{-- Nest a borderless table for a true 2-column table layout --}}
                                                        <table class="table table-sm table-bordered mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    @php 
                                                                        $count = count($multipleQuestionAnswers[$question->id]); 
                                                                    @endphp
                                                                    {{-- Chunk the answers into groups of 2. Each group is a row. --}}
                                                                    @foreach ($multipleQuestionAnswers[$question->id] as $answerChunk)

                                                                        <td style="width: {{ 100 / $count }}%;">
                                                                            @if (isset($answerChunk))
                                                                                {{ $answerChunk->answer_text }}
                                                                            @endif
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    {{-- ✅ Then, check for a single answer --}}
                                                    @elseif (isset($questionAnswers[$question->id]))
                                                        {{ $questionAnswers[$question->id]->answer_text }}

                                                    {{-- If no answer is found, display the default dash --}}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>

                                            {{-- Apply the same logic for sub-questions --}}
                                            @foreach ($question->subQuestions as $sub)
                                                <tr>
                                                    <td class="ps-4">↳ {{ $sub->question_text }}</td>
                                                    <td>
                                                        {{-- ✅ Check for multiple answers for the sub-question --}}
                                                        @if (isset($multipleQuestionAnswers[$sub->id]))
                                                            <table class="table table-sm table-borderless mb-0">
                                                                <tbody>
                                                                    <tr>
                                                                        @php 
                                                                            $count = count($multipleQuestionAnswers[$sub->id]); 
                                                                        @endphp
                                                                        @foreach ($multipleQuestionAnswers[$sub->id] as $answerChunk)
                                                                        <td style="width: {{ 100 / $count }}%;">
                                                                            @if (isset($answerChunk))
                                                                                {{ $answerChunk->answer_text }}
                                                                            @endif
                                                                        </td>
                                                                        @endforeach
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        
                                                        {{-- ✅ Check for a single answer for the sub-question --}}
                                                        @elseif (isset($questionAnswers[$sub->id]))
                                                            {{ $questionAnswers[$sub->id]->answer_text }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                
                                </table>


                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-muted">No survey data found for this answer.</p>
            @endif

        

            {{-- @if ($survey)
                <div class="card mb-4">
                    <div class="card-header h4 bg-primary text-white">
                        <strong>Survey:</strong> {{ $survey->title }}
                    </div>
                    <div class="card-body">
                        @foreach ($survey->sections as $section)
                            <div class="mb-8">
                                <h5 class="text-info">Section: {{ $section->title }}</h5>

                                <table class="table table-sm table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 50%;">Question</th>
                                        <th style="width: 50%;">Answer</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($section->questions as $question)
                                        <tr>
                                            <td>{{ $question->question_text }}</td>
                                            <td>{{ $questionAnswers[$question->id]->answer_text ?? '-' }}</td>
                                        </tr>

                                        @foreach ($question->subQuestions as $sub)
                                            <tr>
                                                <td class="ps-4">↳ {{ $sub->question_text }}</td>
                                                <td>{{ $questionAnswers[$sub->id]->answer_text ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-muted">No survey data found for this answer.</p>
            @endif --}}

        </div>
    </div>

</x-app-layout-admin>
