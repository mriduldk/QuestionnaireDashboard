
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

                    <select name="survey_id" id="survey_id"  class="form-control" required>
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
                <div class="form-group mt-4" id="section-order-preview" style="display:none;">
                    <label>Existing Sections in this Survey:</label>
                    <div id="section-chip-container" class="d-flex flex-wrap gap-2 mt-2"></div>
                </div>



            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>

      <script>
          function loadSectionChips(surveyId) {
              const previewBox = document.getElementById('section-order-preview');
              const chipContainer = document.getElementById('section-chip-container');

              chipContainer.innerHTML = '';
              previewBox.style.display = 'none';

              if (surveyId) {
                  fetch(`/admin/sections/by-survey/${surveyId}`)
                      .then(response => response.json())
                      .then(sections => {
                          if (sections.length) {
                              previewBox.style.display = 'block';
                              sections.sort((a, b) => a.order - b.order).forEach(section => {
                                  const chip = document.createElement('span');
                                  chip.className = 'badge bg-secondary mb-2 mr-2';
                                  chip.textContent = `${section.order}. ${section.title}`;
                                  chip.style.padding = '8px 12px';
                                  chip.style.fontSize = '0.9rem';
                                  chip.style.borderRadius = '20px';
                                  chip.style.marginRight = '5px';
                                  chipContainer.appendChild(chip);
                              });
                          }
                      })
                      .catch(error => console.error('Error fetching sections:', error));
              }
          }

          document.addEventListener('DOMContentLoaded', function () {
              const surveySelect = document.getElementById('survey_id');

              // Call on change
              surveySelect.addEventListener('change', function () {
                  loadSectionChips(this.value);
              });

              // Call on load if pre-selected
              if (surveySelect.value) {
                  loadSectionChips(surveySelect.value);
              }
          });
      </script>




</x-app-layout-admin>
