<x-app-layout-admin>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2 class="card-label">Add User</h2>
        </div>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="form-group">
                    <label>Assign Survey</label>
                    <select name="survey_id" class="form-control" required>
                        <option value="">-- Select Survey --</option>
                        @foreach($surveys as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label>Is Active?</label>
                    <input type="checkbox" name="is_active" value="1" checked>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Create User</button>
            </div>
        </form>
    </div>

</x-app-layout-admin>
