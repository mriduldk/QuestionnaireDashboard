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


    <div class="card">
        <div class="card-header">
            <h2 class="card-label">Add Question</h2>
        </div>

        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <div class="card-body">

                <div class="form-group">
                    <label>Survey</label>
                    <select name="survey_id" id="survey_id" class="form-control" required>
                        <option value="">Select Survey</option>
                        @foreach ($surveys as $survey)
                            <option value="{{ $survey->id }}">{{ $survey->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Section</label>
                    <select name="section_id" id="section_id" class="form-control" required>
                        <option value="">Select Section</option>
                    </select>
                </div>


                {{--<div class="form-group">
                    <label>Section</label>
                    <select name="section_id" class="form-control" required>
                        <option value="">Select Section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->survey->title }} - {{ $section->title }}</option>
                        @endforeach
                    </select>
                </div>--}}

                {{-- OPTIONAL PARENT (for sub-question) --}}
                <div class="form-group">
                    <label>Parent Question (optional)</label>
                    {{--<select name="parent_id" class="form-control">
                        <option value="">None (Top-level question)</option>
                        @foreach ($allQuestions as $q)
                            <option value="{{ $q->id }}">{{ $q->question_text }}</option>
                        @endforeach
                    </select>--}}

                    <select name="parent_id" id="parent_id" class="form-control">
                        <option value="">None (Top-level question)</option>
                    </select>

                </div>

                <div class="form-group">
                    <label>Question Text</label>
                    <input type="text" name="question_text" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Answer Type</label>
                    <select name="type" id="question_type" class="form-control" required onchange="toggleOptions()">
                        @foreach(['text', 'number', 'radio', 'checkbox', 'select', 'textarea'] as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Is Required?</label>
                    <input type="checkbox" name="is_required" value="1">
                </div>

                {{-- <div class="form-group">
                    <label>Metadata (JSON, for options etc.)</label>
                    <textarea name="metadata" class="form-control" rows="3" placeholder='e.g. {"options":["Yes","No"]}'></textarea>
                </div> --}}

                <!-- Conditional metadata options area -->
                <div class="form-group" id="options-container" style="display: none;">
                    <label>Options</label>
                    <div id="options-list">
                        <input type="text" name="metadata[options][]" class="form-control mb-1" placeholder="Option 1">
                    </div>
                    <button type="button" onclick="addOption()" class="btn btn-sm btn-secondary">+ Add Option</button>
                </div>

                <div class="card form-group">
                    <div class="card-header">
                        <strong>Conditional Logic (Optional)</strong>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-4">
                            <label>Dependent on Question</label>
                            {{--<select name="conditional_question_id" id="conditional_question_id" class="form-control" onchange="updateTriggerValues()">
                                <option value="">-- None --</option>
                                @foreach ($allQuestions as $q)
                                    --}}{{-- <option value="{{ $q->id }}">{{ $q->question_text }}</option> --}}{{--
                                    @php $options = $q->metadata['options'] ?? []; @endphp
                                    <option value="{{ $q->id }}"
                                            data-options='@json($options)'>
                                        {{ $q->question_text }}
                                    </option>
                                @endforeach
                            </select>--}}

                            <select name="conditional_question_id" id="conditional_question_id" class="form-control" onchange="updateTriggerValues()">
                                <option value="">-- None --</option>
                            </select>

                        </div>

                        <div class="col-md-3">
                            <label>Operator</label>
                            <select name="conditional_operator" class="form-control">
                                <option value="equals">Equals</option>
                                <option value="not_equals">Not Equals</option>
                                <!-- Add more if needed -->
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label>Triggering Value</label>
                            {{-- <input type="text" name="conditional_value" class="form-control" placeholder="e.g. group"> --}}
                            <select name="conditional_value" id="conditional_value" class="form-control">
                                <option value="">-- Select a value --</option>
                            </select>
                        </div>
                    </div>
                </div>


            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>



<script>
    function toggleOptions() {
        const type = document.getElementById('question_type').value;
        const container = document.getElementById('options-container');
        if (['radio', 'checkbox', 'select'].includes(type)) {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    }

     function addOption() {
        const list = document.getElementById('options-list');
        const wrapper = document.createElement('div');
        wrapper.className = 'input-group mb-1';

        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'metadata[options][]';
        input.className = 'form-control';
        input.placeholder = 'Option';

        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'btn btn-danger';
        button.textContent = '×';
        button.onclick = function () {
            removeOption(button);
        };

        wrapper.appendChild(input);
        wrapper.appendChild(button);
        list.appendChild(wrapper);
    }

    function removeOption(btn) {
        const wrapper = btn.parentElement;
        wrapper.remove();
    }

    function updateTriggerValues() {
        const select = document.getElementById('conditional_question_id');
        const optionsJson = select.options[select.selectedIndex].getAttribute('data-options');
        const triggerDropdown = document.getElementById('conditional_value');

        // clear current options
        triggerDropdown.innerHTML = '<option value="">-- Select a value --</option>';

        if (optionsJson) {
            try {
                const options = JSON.parse(optionsJson);
                options.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.textContent = option;
                    triggerDropdown.appendChild(opt);
                });
            } catch (e) {
                console.error('Invalid JSON in data-options');
            }
        }
    }

    document.querySelector('select[name="section_id"]').addEventListener('change', function () {
        const sectionId = this.value;

        const parentDropdown = document.getElementById('parent_id');
        const conditionalDropdown = document.getElementById('conditional_question_id');

        // Clear both dropdowns
        parentDropdown.innerHTML = '<option value="">None (Top-level question)</option>';
        conditionalDropdown.innerHTML = '<option value="">-- None --</option>';

        if (sectionId) {
            fetch(`/admin/questions/by-section/${sectionId}`)
                .then(response => response.json())
                .then(questions => {
                    questions.forEach(q => {
                        // Add to Parent Question dropdown
                        const parentOpt = document.createElement('option');
                        parentOpt.value = q.id;
                        parentOpt.textContent = q.question_text;
                        parentDropdown.appendChild(parentOpt);

                        // Add to Conditional Question dropdown
                        const condOpt = document.createElement('option');
                        condOpt.value = q.id;
                        condOpt.textContent = q.question_text;
                        condOpt.setAttribute('data-options', JSON.stringify(q.metadata?.options ?? []));
                        conditionalDropdown.appendChild(condOpt);
                    });
                })
                .catch(error => {
                    console.error('Error fetching questions:', error);
                });
        }
    });

    document.getElementById('survey_id').addEventListener('change', function () {
        const surveyId = this.value;
        const sectionSelect = document.getElementById('section_id');

        sectionSelect.innerHTML = '<option value="">Select Section</option>';

        if (surveyId) {
            fetch(`/admin/sections/by-survey/${surveyId}`)
                .then(response => response.json())
                .then(sections => {
                    sections.forEach(section => {
                        const opt = document.createElement('option');
                        opt.value = section.id;
                        opt.textContent = section.title;
                        sectionSelect.appendChild(opt);
                    });
                })
                .catch(error => {
                    console.error('Error fetching sections:', error);
                });
        }

        // Clear question-based dropdowns when survey changes
        document.getElementById('parent_id').innerHTML = '<option value="">None (Top-level question)</option>';
        document.getElementById('conditional_question_id').innerHTML = '<option value="">-- None --</option>';
    });
</script>


</x-app-layout-admin>
