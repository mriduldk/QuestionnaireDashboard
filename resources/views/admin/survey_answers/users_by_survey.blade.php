<x-app-layout-admin>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2 class="card-label">User List</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="kt_datatables">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Father's Name</th>
                    <th>Address</th>
                    <th>Photo</th>
                    <th>Survey</th>
                    <th>Survey Answer Count</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}<br>{{ $u->phone }}</td>

                        <td>{{ $u->father_name }}</td>
                        <td>{{ $u->village }} {{ $u->address }}</td>
                        <td>
                            @if($u->photo)
                                <img src="{{ asset($u->photo) }}" height="50">
                            @endif
                        </td>

                        <td>{{ $u->survey->title ?? 'N/A' }}</td>
                        <td>
                            <p>
                                <span class="badge rounded-pill">
                                    {{ $u->survey_answers_count }} Answers
                                </span>
                            </p>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $u->user_id) }}" class="btn btn-sm btn-info btn-block mb-1">View Details</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout-admin>
