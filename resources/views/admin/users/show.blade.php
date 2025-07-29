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
                    <th>Father's Name</th>
                    <td>{{ $user->father_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email ?? 'N/A' }}</td>
                    <th>Phone</th>
                    <td>{{ $user->phone ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Village</th>
                    <td>{{ $user->village ?? 'N/A' }}</td>
                    <th>Address</th>
                    <td>{{ $user->address ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>District</th>
                    <td>{{ $user->districtInfo?->name ?? 'N/A' }}</td>
                    <th>Sub-Division</th>
                    <td>{{ $user->subDivisionInfo?->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Block</th>
                    <td>{{ $user->blockInfo?->name ?? 'N/A' }}</td>
                    <th>VCDC</th>
                    <td>{{ $user->vcdcInfo?->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Survey</th>
                    <td>{{ $user->survey?->title ?? 'N/A' }}</td>
                    <th>Is Active?</th>
                    <td>{{ $user->is_active ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <th>Email Verified?</th>
                    <td>{{ $user->is_email_verified ? 'Yes' : 'No' }}</td>
                    <th>Created At</th>
                    <td>{{ $user->created_at?->format('d-m-Y h:i A') ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Photo</th>
                    <td colspan="3">
                        @if ($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" height="100">
                        @else
                            N/A
                        @endif
                    </td>
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
                        <th>Responder's Name</th>
                        <th>Responder's Phone</th>
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
                            <td>{{ $answer->name }}</td>
                            <td>{{ $answer->phone_number }}</td>
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
