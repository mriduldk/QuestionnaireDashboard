<x-app-layout-admin>

    <style>
        .survey-card {
            color: white;
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
            height: 160px; /* 🔧 Set fixed height */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .survey-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }

        .survey-card .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .survey-card .badge {
            background-color: rgba(255, 255, 255, 0.25);
            color: #fff;
            font-weight: 500;
        }

        /* 🔷 Gradient backgrounds */
        .gradient-1 { background: linear-gradient(135deg, #ff6a00, #ee0979); }
        .gradient-2 { background: linear-gradient(135deg, #42e695, #3bb2b8); }
        .gradient-3 { background: linear-gradient(135deg, #007adf, #00ecbc); }
        .gradient-4 { background: linear-gradient(135deg, #ff4e50, #f9d423); }
        .gradient-5 { background: linear-gradient(135deg, #8e2de2, #4a00e0); }
        .gradient-6 { background: linear-gradient(135deg, #00b4db, #0083b0); }
    </style>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <h2 class="mb-3">Surveys</h2>
        <div class="row">
            @forelse($surveys as $index => $survey)
                @php
                    $gradientClass = 'gradient-' . (($index % 6) + 1);
                @endphp
                <div class="col-md-3 mb-4">
                    <a href="{{ route('surveys.answers', $survey->id) }}" class="text-decoration-none">
                        <div class="card survey-card {{ $gradientClass }} shadow-sm">
                            <div>
                                <h5 class="card-title">{{ $survey->title }}</h5>
                                <p class="mb-0 mt-2">
                                    <span class="badge rounded-pill">
                                        {{ $survey->survey_answers_count }} Answers
                                    </span>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p>No surveys available.</p>
            @endforelse
        </div>
    </div>

</x-app-layout-admin>
