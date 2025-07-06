<x-app-layout-admin>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h2 class="card-label">Edit User</h2>
        </div>

        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf @method('PUT')
            <div class="card-body">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                </div>

                {{--<div class="form-group">
                    <label>New Password (optional)</label>
                    <input type="password" name="password" class="form-control">
                </div>--}}

                <div class="form-group">
                    <label>Is Active?</label>
                    <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>
        </form>
    </div>

</x-app-layout-admin>
