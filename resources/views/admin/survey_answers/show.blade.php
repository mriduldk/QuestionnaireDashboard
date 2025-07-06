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
            {{-- Basic info --}}
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>Name</th><td>{{ $surveyAnswer->name }}</td>
                    <th>Phone</th><td>{{ $surveyAnswer->phone_number }}</td>
                    <th>Age</th><td>{{ $surveyAnswer->age }}</td>
                </tr>
                <tr>
                    <th>Gender</th><td>{{ ucfirst($surveyAnswer->gender) }}</td>
                    <th>Voter ID</th><td>{{ $surveyAnswer->voter_id }}</td>
                    <th>Caste</th><td>{{ $surveyAnswer->caste }}</td>
                </tr>
                <tr>
                    <th>District</th><td>{{ $surveyAnswer->district }}</td>
                    <th>Block</th><td>{{ $surveyAnswer->block }}</td>
                    <th>Village</th><td>{{ $surveyAnswer->village }}</td>
                </tr>
                <tr>
                    <th>Household Members</th>
                    <td colspan="5">{{ implode(', ', $surveyAnswer->house_hold_member ?? []) }}</td>
                </tr>
                <tr>
                    <th>Other Household Member</th>
                    <td colspan="5">{{ $surveyAnswer->house_hold_member_other }}</td>
                </tr>
                <tr>
                    <th>Livelihood Activities</th>
                    <td colspan="5">{{ implode(', ', $surveyAnswer->household_livelihood_activities ?? []) }}</td>
                </tr>
                <tr>
                    <th>Other Activity</th>
                    <td colspan="5">{{ $surveyAnswer->household_livelihood_activity_other }}</td>
                </tr>
                <tr>
                    <th>Avg Income</th>
                    <td>{{ $surveyAnswer->average_annual_income }}</td>
                    <th>Status</th>
                    <td>{{ $surveyAnswer->status }}</td>
                    <th>Last Updated At</th>
                    <td>{{ $surveyAnswer->updated_at ? $surveyAnswer->updated_at->format('d-m-Y h:i A') : 'N/A' }}</td>
                </tr>
                </tbody>
            </table>

            {{-- Survey Sections, Questions, Sub-Questions --}}
            @if ($survey)
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
            @endif

        </div>
    </div>

</x-app-layout-admin>
