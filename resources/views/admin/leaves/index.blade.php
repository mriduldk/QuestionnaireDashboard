<x-app-layout-admin>

    <div class="card p-4">
        <h4 class="mb-4">Leave Applications</h4>

        {{-- Filter Form --}}
        <form method="GET" class="row g-3 mb-4">
           {{-- <div class="col-md-3">
                <span>Submitted By</span>
                <input type="text" name="submitted_by" value="{{ request('submitted_by') }}" class="form-control" placeholder="Submitted By (User ID)">
            </div>--}}
            <div class="col-md-3">
                <span>Leave Types</span>
                <select name="leave_type" class="form-control">
                    <option value="">All</option>
                    <option value="Medical Leave" {{ request('leave_type') == 'Medical Leave' ? 'selected' : '' }}>Medical Leave</option>
                    <option value="Personal Leave" {{ request('leave_type') == 'Personal Leave' ? 'selected' : '' }}>Personal Leave</option>
                    <option value="Others" {{ request('leave_type') == 'Others' ? 'selected' : '' }}>Others</option>
                </select>
            </div>
            <div class="col-md-3">
                <span>Approval Status</span>
                <select name="is_approved" class="form-control">
                    <option value="">All</option>
                    <option value="1" {{ request('is_approved') === '1' ? 'selected' : '' }}>Approved</option>
                    <option value="2" {{ request('is_approved') === '2' ? 'selected' : '' }}>Rejected</option>
                    <option value="0" {{ request('is_approved') === '0' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100 mt-5" type="submit">Filter</button>
            </div>
        </form>

        {{-- Table --}}
        <table class="table table-bordered table-hover" id="kt_datatables">
            <thead>
            <tr>
                <th>Leave Application ID</th>
                <th>Leave Type</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Submitted By</th>
                <th>Status</th>
                <th>Submitted On</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($leaves as $leave)
                <tr>
                    <td><b>{{ $leave->leave_application_id }}</b></td>
                    <td>{{ $leave->leave_type }}</td>
                    <td>{{ $leave->date_from }}</td>
                    <td>{{ $leave->date_to }}</td>
                    <td>{{ $leave->submitter?->name ?? $leave->submitted_by }}</td>
                    <td>
                        @if($leave->is_approved === 1)
                            <span class="badge bg-success text-white">Approved</span>
                        @elseif($leave->is_approved === 2)
                            <span class="badge bg-danger text-white">Rejected</span>
                        @else
                            <span class="badge bg-warning text-white">Pending</span>
                        @endif
                    </td>
                    <td>{{ $leave->submitted_on?->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('leaves.show', $leave->id) }}" class="btn btn-sm btn-info">View Details</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No records found</td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>

</x-app-layout-admin>
