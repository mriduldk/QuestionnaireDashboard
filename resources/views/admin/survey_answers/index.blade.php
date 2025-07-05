<x-app-layout-admin>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2 class="card-label">Survey Answers</h2>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped" id="kt_datatables">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>District</th>
                    <th>Sub Division</th>
                    <th>Block</th>
                    <th>VCDC</th>
                    <th>Village</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Last Updated On</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($surveyAnswers as $answer)
                    <tr>
                        <td>{{ $answer->name }}</td>
                        <td>{{ $answer->phone_number }}</td>
                        <td>{{ $answer->district }}</td>
                        <td>{{ $answer->sub_division }}</td>
                        <td>{{ $answer->block }}</td>
                        <td>{{ $answer->vcdc }}</td>
                        <td>{{ $answer->village }}</td>
                        <td>
                            @if (strtolower($answer->status) === 'draft')
                                <span class="badge bg-warning text-dark">Draft</span>
                            @elseif (strtolower($answer->status) === 'completed')
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($answer->status) }}</span>
                            @endif
                        </td>
                        <td>
                            {{ $answer->user?->name ?? 'N/A' }}
                        </td>
                        <td>{{ $answer->updated_at?->format('d-m-Y h:i A') ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('survey-answers.show', $answer->survey_answer_id) }}" class="btn btn-sm btn-info">
                                View Details
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout-admin>
