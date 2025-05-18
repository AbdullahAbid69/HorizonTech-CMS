@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">New Student Dashboard</h1>

        @if(!$application)
            <div class="alert alert-warning">
                <h4><i class="fas fa-exclamation-triangle"></i> Application Not Submitted</h4>
                <p>You haven't submitted your application yet. Please complete the application form to proceed.</p>
                <a href="{{ route('newStudent.app.comp') }}" class="btn btn-primary">
                    <i class="fas fa-file-alt"></i> Complete Application
                </a>
            </div>
        @elseif($application && !$application->isApproved)
            <div class="alert alert-info">
                <h4><i class="fas fa-clock"></i> Application Submitted</h4>
                <p>Your application was submitted on
                    <strong>{{ $application->created_at->format('d M Y') }}</strong>.
                </p>
                <p class="mb-0">Status: <span class="badge badge-warning">Pending Approval</span></p>
            </div>
        @else
            <div class="alert alert-success">
                <h4><i class="fas fa-check-circle"></i> Application Approved</h4>
                <p>Welcome to Horizon Institute of Health Sciences!</p>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50">Programs Offered</h6>
                                <h3 class="mb-0">{{ $programs->count() }}</h3>
                            </div>
                            <i class="fas fa-graduation-cap fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50">Instructors</h6>
                                <h3 class="mb-0">{{ $instructorsCount }}</h3>
                            </div>
                            <i class="fas fa-chalkboard-teacher fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50">Current Students</h6>
                                <h3 class="mb-0">{{ $studentsCount }}</h3>
                            </div>
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Programs Offered Section -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-book-open"></i> Programs Offered</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($programs as $program)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">{{ $program->name }}</h5>
                                    <p class="card-text">{{ Str::limit($program->description, 150) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <!-- <i class="fas fa-clock"></i> Duration: {{ $program->duration }} -->
                                        </small>
                                        {{-- <a href="#" class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                            data-target="#programModal{{ $program->id }}">
                                            Details
                                        </a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Program Modal -->
                        <div class="modal fade" id="programModal{{ $program->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="programModalLabel{{ $program->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="programModalLabel{{ $program->id }}">{{ $program->name }}
                                        </h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Program Details</h6>
                                                <p>{{ $program->description }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Key Information</h6>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">
                                                        <strong>Duration:</strong> {{ $program->duration }}
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Credits:</strong> {{ $program->credits }}
                                                    </li>
                                                    <li class="list-group-item">
                                                        <strong>Tuition Fee:</strong> ${{ number_format($program->fee, 2) }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        @if($application && $application->isApproved)
                                            <a href="#" class="btn btn-primary">Enroll Now</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Upcoming Events Section -->

    </div>



    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card {
            border-radius: 10px;
            overflow: hidden;
        }
    </style>

@endsection