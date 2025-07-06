
<x-app-layout-admin>

  @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

      @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if(session('error'))
          <div class="alert alert-danger">
              {{ session('error') }}
          </div>
      @endif


    <div class="card">
        <div class="card-header">
            <h2 class="card-label">Add Section</h2>
        </div>

        <form action="{{ route('sections.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label>Survey:</label>
                    {{--<select name="survey_id" class="form-control" required>
                        <option value="">Select a Survey</option>
                        @foreach ($surveys as $id => $title)
                            <option value="{{ $id }}" {{ old('survey_id') == $id ? 'selected' : '' }}>
                                {{ $title }}
                            </option>
                        @endforeach
                    </select>--}}

                    <select name="survey_id" class="form-control" required>
                        <option value="">Select a Survey</option>
                        @foreach ($surveys as $id => $title)
                            <option value="{{ $id }}"
                                {{ old('survey_id', $selectedSurveyId) == $id ? 'selected' : '' }}>
                                {{ $title }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="form-group">
                    <label>Section Title:</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Order</label>
                    <input type="number" name="order" class="form-control" required/>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>


</x-app-layout-admin>
