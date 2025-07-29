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

        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="form-group">
                    <label>Father's Name</label>
                    <input type="text" name="father_name" class="form-control" value="{{ old('father_name', $user->father_name) }}">
                </div>

                <div class="form-group">
                    <label>Village</label>
                    <input type="text" name="village" class="form-control" value="{{ old('village', $user->village) }}">
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Photo</label>
                    <input type="file" name="photo" class="form-control">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" height="80">
                    @endif
                </div>

                <div class="form-group">
                    <label>Assign Survey</label>
                    <select name="survey_id" class="form-control" required>
                        <option value="">-- Select Survey --</option>
                        @foreach($surveys as $id => $title)
                            <option value="{{ $id }}" {{ $user->survey_id == $id ? 'selected' : '' }}>{{ $title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>District</label>
                    <select name="district_id" id="district_id" class="form-control" required>
                        <option value="">-- Select District --</option>
                        @foreach($districts as $id => $name)
                            <option value="{{ $id }}" {{ $user->district == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Sub-Division</label>
                    <select name="sub_division_id" id="sub_division_id" class="form-control" required>
                        <option value="">-- Select Sub-Division --</option>
                        @foreach($subDivisions as $id => $name)
                            <option value="{{ $id }}" {{ $user->sub_division == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Block</label>
                    <select name="block_id" id="block_id" class="form-control" required>
                        <option value="">-- Select Block --</option>
                        @foreach($blocks as $id => $name)
                            <option value="{{ $id }}" {{ $user->block == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>VCDC</label>
                    <select name="vcdc_id" id="vcdc_id" class="form-control" required>
                        <option value="">-- Select VCDC --</option>
                        @foreach($vcdcs as $id => $name)
                            <option value="{{ $id }}" {{ $user->vcdc == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

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

    @push('scripts')
        <script>
            $('select[name="district_id"]').on('change', function () {
                let districtId = $(this).val();
                if (districtId) {
                    $.get('/admin/api/sub-divisions/' + districtId, function (data) {
                        let options = '<option value="">-- Select Sub-Division --</option>';
                        $.each(data, function (id, name) {
                            options += `<option value="${id}">${name}</option>`;
                        });
                        $('select[name="sub_division_id"]').html(options).val('');
                        $('select[name="block_id"]').html('<option value="">-- Select Block --</option>');
                        $('select[name="vcdc_id"]').html('<option value="">-- Select VCDC --</option>');
                    });
                }
            });

            $('select[name="sub_division_id"]').on('change', function () {
                let subDivisionId = $(this).val();
                if (subDivisionId) {
                    $.get('/admin/api/blocks/' + subDivisionId, function (data) {
                        let options = '<option value="">-- Select Block --</option>';
                        $.each(data, function (id, name) {
                            options += `<option value="${id}">${name}</option>`;
                        });
                        $('select[name="block_id"]').html(options).val('');
                        $('select[name="vcdc_id"]').html('<option value="">-- Select VCDC --</option>');
                    });
                }
            });

            $('select[name="block_id"]').on('change', function () {
                let blockId = $(this).val();
                if (blockId) {
                    $.get('/admin/api/vcdcs/' + blockId, function (data) {
                        let options = '<option value="">-- Select VCDC --</option>';
                        $.each(data, function (id, name) {
                            options += `<option value="${id}">${name}</option>`;
                        });
                        $('select[name="vcdc_id"]').html(options).val('');
                    });
                }
            });
        </script>
    @endpush

</x-app-layout-admin>
