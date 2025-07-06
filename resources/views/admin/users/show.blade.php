<x-app-layout-admin>
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-label">User Information</h2>
        </div>

        <div class="card-body">
            <table class="table table-bordered w-100">
                <tr>
                    <th>Name</th>
                    <td>{{ $user->name ?? 'N/A' }}</td>
                    <th>Email</th>
                    <td>{{ $user->email ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $user->phone ?? 'N/A' }}</td>
                    <th>Active</th>
                    <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <th>Email Verified</th>
                    <td>{{ $user->is_email_verified ? 'Yes' : 'No' }}</td>
                    <th>Created At</th>
                    <td>{{ $user->created_at?->format('d-m-Y h:i A') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <hr>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h2 class="card-label">Survey Answers Submitted by {{ $user->name }}</h2>
        </div>

        <div class="card-body">
            @if ($surveyAnswers->isEmpty())
                <p class="text-muted">No survey answers submitted by this user.</p>
            @else
                <table class="table table-bordered table-striped" id="kt_datatables">
                    <thead>
                    <tr>
                        {{--<th>Name</th>
                        <th>Phone</th>--}}
                        <th>District</th>
                        <th>Sub Division</th>
                        <th>Block</th>
                        <th>VCDC</th>
                        <th>Village</th>
                        <th>Submitted On</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($surveyAnswers as $answer)
                        <tr>
                            {{--<td>{{ $answer->name }}</td>
                            <td>{{ $answer->phone_number }}</td>--}}
                            <td>{{ $answer->district }}</td>
                            <td>{{ $answer->sub_division }}</td>
                            <td>{{ $answer->block }}</td>
                            <td>{{ $answer->vcdc }}</td>
                            <td>{{ $answer->village }}</td>
                            <td>{{ $answer->created_at?->format('d-m-Y h:i A') }}</td>
                            <td>
                                <a href="{{ route('survey-answers.show', $answer->survey_answer_id) }}"
                                   class="btn btn-sm btn-primary">View</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout-admin>
