<x-app-layout-admin>

    {{-- Alerts --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
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
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h2 class="card-label">Create Survey Section</h2>
                </div>

                <form action="{{ route('survey-sections.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        
                        {{-- Select Survey --}}
                        <div class="form-group">
                            <label for="survey_id">Survey</label>
                            <select name="survey_id" id="survey_id" class="form-control" required>
                                <option value="">-- Choose Survey --</option>
                                @foreach($surveys as $survey)
                                    <option value="{{ $survey->id }}" {{ old('survey_id') == $survey->id ? 'selected' : '' }}>
                                        {{ $survey->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Section Title --}}
                        <div class="form-group">
                            <label for="title">Section Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                   class="form-control" placeholder="Enter section title" required>
                        </div>



                        {{-- Components JSON --}}
                        <div class="form-group">
                            <label for="components">Components (JSON)</label>
                            <textarea name="components" id="components" rows="10" class="form-control"
                                      placeholder='[{"type":"Text","id":"village","label":"Village/Town Name","hint":"Enter village/town name","required":true}]'>{{ old('components') }}</textarea>
                            <small class="form-text text-muted">
                                Enter a valid JSON structure of components.
                            </small>
                        </div>


                        {{-- Components JSON Builder --}}
                        <div class="form-group">
                            <label>Section Fields / Components</label>
                            <table class="table table-bordered" id="components-table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Key/ID</th>
                                        <th>Label</th>
                                        <th>Options (comma separated)</th>
                                        <th>Required</th>
                                        <th>Extra (Hint / Regex / Min / Max)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="components[0][type]" class="form-control">
                                                <option value="Text">Text</option>
                                                <option value="Number">Number</option>
                                                <option value="Dropdown">Dropdown</option>
                                                <option value="AutoComplete">AutoComplete</option>
                                                <option value="Radio">Radio</option>
                                                <option value="Checkbox">Checkbox</option>
                                                <option value="Date">Date</option>
                                                <option value="Button">Button</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="components[0][id]" class="form-control" placeholder="field key/id"></td>
                                        <td><input type="text" name="components[0][label]" class="form-control" placeholder="Label"></td>
                                        <td><input type="text" name="components[0][options]" class="form-control" placeholder="Comma separated"></td>
                                        <td><input type="checkbox" name="components[0][required]" value="1"></td>
                                        <td>
                                            <input type="text" name="components[0][hint]" class="form-control mb-1" placeholder="Hint">
                                            <input type="text" name="components[0][regex]" class="form-control mb-1" placeholder="Regex">
                                            <input type="number" name="components[0][min]" class="form-control mb-1" placeholder="Min">
                                            <input type="number" name="components[0][max]" class="form-control" placeholder="Max">
                                        </td>
                                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-primary btn-sm mt-2" onclick="addRow()">+ Add Field</button>
                            <small class="form-text text-muted">Define the fields/keys for this section. Only enter key info, the user input will be rendered later.</small>
                        </div>

                        
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('survey-sections.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Save Section</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
      let rowIndex = 1;
      function addRow() {
          const table = document.getElementById('components-table').getElementsByTagName('tbody')[0];
          const row = `<tr>
              <td>
                  <select name="components[${rowIndex}][type]" class="form-control">
                      <option value="Text">Text</option>
                      <option value="Number">Number</option>
                      <option value="Dropdown">Dropdown</option>
                      <option value="AutoComplete">AutoComplete</option>
                      <option value="Radio">Radio</option>
                      <option value="Checkbox">Checkbox</option>
                      <option value="Date">Date</option>
                      <option value="Button">Button</option>
                  </select>
              </td>
              <td><input type="text" name="components[${rowIndex}][id]" class="form-control" placeholder="field key/id"></td>
              <td><input type="text" name="components[${rowIndex}][label]" class="form-control" placeholder="Label"></td>
              <td><input type="text" name="components[${rowIndex}][options]" class="form-control" placeholder="Comma separated"></td>
              <td><input type="checkbox" name="components[${rowIndex}][required]" value="1"></td>
              <td>
                  <input type="text" name="components[${rowIndex}][hint]" class="form-control mb-1" placeholder="Hint">
                  <input type="text" name="components[${rowIndex}][regex]" class="form-control mb-1" placeholder="Regex">
                  <input type="number" name="components[${rowIndex}][min]" class="form-control mb-1" placeholder="Min">
                  <input type="number" name="components[${rowIndex}][max]" class="form-control" placeholder="Max">
              </td>
              <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">Remove</button></td>
          </tr>`;
          table.insertAdjacentHTML('beforeend', row);
          rowIndex++;
      }

      function removeRow(btn) {
          const row = btn.closest('tr');
          row.remove();
      }
  </script>


</x-app-layout-admin>
