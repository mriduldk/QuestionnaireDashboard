<x-app-layout-admin>
    <div class="card p-4">
        <h4>Leave Application #{{ $leave->id }}</h4>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered mt-3">
            <tr><th>Leave Type</th><td>{{ $leave->leave_type }}</td></tr>
            <tr><th>Date From</th><td>{{ $leave->date_from }}</td></tr>
            <tr><th>Date To</th><td>{{ $leave->date_to }}</td></tr>
            <tr><th>Reason</th><td>{{ $leave->reason }}</td></tr>
            <tr><th>Attachment</th>
                <td>
                    @if($leave->attachment)
                        <a href="{{ asset('storage/'.$leave->attachment) }}" target="_blank">View Attachment</a>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            <tr><th>Submitted By</th><td>{{ $leave->submitter?->name ?? $leave->submitted_by }}</td></tr>
            <tr><th>Submitted On</th><td>{{ $leave->submitted_on?->format('d-m-Y H:i') }}</td></tr>
            <tr><th>Status</th>
                <td>
                    @if($leave->is_approved === 0)
                        <span class="badge bg-warning text-white">Pending</span>
                    @elseif($leave->is_approved === 1)
                        <span class="badge bg-success text-white">Approved</span>
                    @elseif($leave->is_approved === 2)
                        <span class="badge bg-danger text-white">Rejected</span>
                    @else
                        <span class="badge bg-warning text-white">Pending</span>
                    @endif
                </td>
            </tr>
            <tr><th>Approved By</th><td>{{ $leave->approver?->name ?? 'N/A' }}</td></tr>
            <tr><th>Approved On</th><td>{{ $leave->approved_on?->format('d-m-Y H:i') ?? 'N/A' }}</td></tr>
            <tr><th>Remarks</th><td>{{ $leave->remarks ?? 'N/A' }}</td></tr>
        </table>

        {{-- Approve / Reject Buttons (only if pending) --}}
        @if($leave->is_approved === 0)
            <form method="POST" action="" id="decisionForm" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Enter remarks (optional)"></textarea>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('leaves.index') }}" class="btn btn-secondary mr-2">Back</a>
                    <button type="submit" formaction="{{ route('leaves.approve', $leave->id) }}" class="btn btn-success mr-2">Approve</button>
                    <button type="submit" formaction="{{ route('leaves.reject', $leave->id) }}" class="btn btn-danger">Reject</button>
                </div>
            </form>
        @else
            <a href="{{ route('leaves.index') }}" class="btn btn-secondary mt-3">Back</a>
        @endif
    </div>
</x-app-layout-admin>
