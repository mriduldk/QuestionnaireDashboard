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
            <h2 class="card-label">Edit Question</h2>
        </div>

        <form method="POST" action="{{ route('questions.update', $question) }}">
            @csrf @method('PUT')
            <div class="card-body">

                {{-- Survey --}}
                <div class="form-group">
                    <label>Survey</label>
                    <select name="survey_id" id="survey_id" class="form-control" required>
                        <option value="">Select Survey</option>
                        @foreach ($surveys as $survey)
                            <option value="{{ $survey->id }}" {{ $question->section->survey_id == $survey->id ? 'selected' : '' }}>
                                {{ $survey->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Section --}}
                <div class="form-group">
                    <label>Section</label>
                    <select name="section_id" id="section_id" class="form-control" required>
                        <option value="">Select Section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}"
                                {{ $question->section_id == $section->id ? 'selected' : '' }}>
                                {{ $section->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Parent Question --}}
                <div class="form-group">
                    <label>Parent Question (optional)</label>
                    <select name="parent_id" id="parent_id" class="form-control">
                        <option value="">None (Top-level question)</option>
                    </select>
                </div>

                {{-- Question Text --}}
                <div class="form-group">
                    <label>Question Text</label>
                    <input type="text" name="question_text" class="form-control" required value="{{ $question->question_text }}">
                </div>

                {{-- Type --}}
                <div class="form-group">
                    <label>Answer Type</label>
                    <select name="type" id="question_type" class="form-control" required onchange="toggleOptions()">
                        @foreach(['text', 'number', 'radio', 'checkbox', 'select', 'textarea'] as $type)
                            <option value="{{ $type }}" {{ $question->type == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Required --}}
                <div class="form-group">
                    <label>Is Required?</label>
                    <input type="checkbox" name="is_required" value="1" {{ $question->is_required ? 'checked' : '' }}>
                </div>

                {{-- Options (if applicable) --}}
                <div class="form-group" id="options-container" style="display: none;">
                    <label>Options</label>
                    <div id="options-list">
                        @php
                            $options = $question->metadata['options'] ?? [];
                        @endphp
                        @foreach ($options as $opt)
                            <div class="input-group mb-1">
                                <input type="text" name="metadata[options][]" class="form-control" value="{{ $opt }}">
                                <button type="button" class="btn btn-danger" onclick="removeOption(this)">×</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addOption()" class="btn btn-sm btn-secondary">+ Add Option</button>
                </div>

                {{-- Conditional Logic --}}
                <div class="card form-group">
                    <div class="card-header">
                        <strong>Conditional Logic (Optional)</strong>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-4">
                            <label>Dependent on Question</label>
                            <select name="conditional_question_id" id="conditional_question_id" class="form-control" onchange="updateTriggerValues()">
                                <option value="">-- None --</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Operator</label>
                            <select name="conditional_operator" class="form-control">
                                {{--<option value="equals" {{ $question->conditional_logic['show_if']['operator'] == 'equals' ? 'selected' : '' }}>Equals</option>
                                <option value="not_equals" {{ $question->conditional_logic['show_if']['operator'] == 'not_equals' ? 'selected' : '' }}>Not Equals</option>--}}

                                @php
                                    $logic = $question->conditional_logic['show_if'] ?? [];
                                @endphp

                                <option value="equals" {{ ($logic['operator'] ?? '') === 'equals' ? 'selected' : '' }}>Equals</option>
                                <option value="not_equals" {{ ($logic['operator'] ?? '') === 'not_equals' ? 'selected' : '' }}>Not Equals</option>


                            </select>
                        </div>

                        <div class="col-md-5">
                            <label>Triggering Value</label>
                            <select name="conditional_value" id="conditional_value" class="form-control">
                                <option value="">-- Select a value --</option>
                                @if(isset($question->conditional_logic['show_if']['value']))
                                    <option selected>{{ $question->conditional_logic['show_if']['value'] }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary mt-3">Update Question</button>

            </div>
        </form>
    </div>

    {{-- Script --}}
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
            btn.parentElement.remove();
        }

        function updateTriggerValues() {
            const select = document.getElementById('conditional_question_id');
            const optionsJson = select.options[select.selectedIndex].getAttribute('data-options');
            const triggerDropdown = document.getElementById('conditional_value');

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
                    });
            }

            document.getElementById('parent_id').innerHTML = '<option value="">None (Top-level question)</option>';
            document.getElementById('conditional_question_id').innerHTML = '<option value="">-- None --</option>';
        });

        document.getElementById('section_id').addEventListener('change', function () {
            const sectionId = this.value;
            const parentDropdown = document.getElementById('parent_id');
            const conditionalDropdown = document.getElementById('conditional_question_id');

            parentDropdown.innerHTML = '<option value="">None (Top-level question)</option>';
            conditionalDropdown.innerHTML = '<option value="">-- None --</option>';

            if (sectionId) {
                fetch(`/admin/questions/by-section/${sectionId}`)
                    .then(response => response.json())
                    .then(questions => {
                        questions.forEach(q => {
                            const opt1 = document.createElement('option');
                            opt1.value = q.id;
                            opt1.textContent = q.question_text;
                            if (q.id == {{ $question->parent_id ?? 'null' }}) opt1.selected = true;
                            parentDropdown.appendChild(opt1);

                            const opt2 = document.createElement('option');
                            opt2.value = q.id;
                            opt2.textContent = q.question_text;
                            opt2.setAttribute('data-options', JSON.stringify(q.metadata?.options ?? []));
                            if (q.id == {{ $question->conditional_logic['show_if']['question_id'] ?? 'null' }}) opt2.selected = true;
                            conditionalDropdown.appendChild(opt2);
                        });

                        updateTriggerValues(); // populate conditional values if applicable
                    });
            }
        });

        // Initialize values on load
        document.addEventListener('DOMContentLoaded', function () {
            toggleOptions();
            document.getElementById('survey_id').dispatchEvent(new Event('change'));

            setTimeout(() => {
                document.getElementById('section_id').value = {{ $question->section_id }};
                document.getElementById('section_id').dispatchEvent(new Event('change'));
            }, 200);
        });
    </script>

</x-app-layout-admin>
