@extends('layout.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h1 class="mb-0 fw-bold text-black"><i class="fa fa-chalkboard-teacher me-2"></i>Instructor Dashboard</h1>
            <span class="badge bg-primary text-white fs-5">{{ Auth::user()->name }}</span>
        </div>
    </div>
    <div class="row g-4">
        <!-- Stats Cards -->
        <div class="col-md-4">
            <div class="card shadow border-0 text-center h-100 bg-primary text-white">
                <div class="card-body py-4">
                    <div class="mb-2">
                        <i class="fa fa-book fa-2x" style="color:#fff;"></i>
                    </div>
                    <h6 class="text-white">Courses Allotted</h6>
                    <div class="display-5 fw-bold text-white">{{ $totalCourses }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow border-0 text-center  bg-primary h-100">
                <div class="card-body py-4">
                    <div class="mb-2">
                        <i class="fa fa-layer-group fa-2x" style="color:#fff;"></i>
                    </div>
                    <h6 class="text-white">Programs Allotted</h6>
                    <div class="display-5 fw-bold text-white">{{ $totalPrograms }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow border-0 text-center bg-primary h-100" style="color:#fff;">
                <div class="card-body py-4">
                    <div class="mb-2">
                        <i class="fa fa-calendar fa-2x" style="color:#fff;"></i>
                    </div>
                    <h6 class="text-white">Upcoming Lectures</h6>
                    <div class="display-5 fw-bold text-white">{{ $totalLectures ?? $upcomingLectures->count() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mt-4">
        <!-- Assigned Courses -->
        <div class="col-md-6">
            <div class="card shadow border-0 mb-4">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fa fa-book me-2"></i>Assigned Courses
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($assignedCourses as $assignment)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <strong>{{ $assignment->course->title ?? 'Unknown Course' }}</strong>
                                <span class="badge bg-primary text-white ms-2">{{ $assignment->course->code ?? 'N/A' }}</span>
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No courses assigned.</li>
                    @endforelse
                </ul>
            </div>
            <!-- Assigned Programs -->
            <div class="card shadow border-0">
                <div class="card-header" style="background:#198754;color:#fff;font-weight:bold;">
                    <i class="fa fa-layer-group me-2"></i>Assigned Programs
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($assignedPrograms as $assignment)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>
                                <strong>{{ $assignment->program->name ?? 'Unknown Program' }}</strong>
                                <span class="badge" style="background:#198754;color:#fff;">{{ $assignment->program->code ?? 'N/A' }}</span>
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No programs assigned.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <!-- Upcoming Lectures -->
        <div class="col-md-6">
            <div class="card shadow border-0 mb-4 bg-light">
                <div class="card-header" style="background:#0dcaf0;color:#212529;font-weight:bold;">
                    <i class="fa fa-calendar me-2"></i>Today's Upcoming Lectures ({{ now()->setTimezone('Asia/Karachi')->format('l') }})
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($upcomingLectures as $lecture)
                        <li class="list-group-item bg-white">
                            <div class="fw-bold text-primary">{{ $lecture->instructorCourseAssignment->course->title ?? 'Unknown Course' }}</div>
                            <div class="small text-muted">
                                Time: {{ \Carbon\Carbon::parse($lecture->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($lecture->end_time)->format('h:i A') }}<br>
                                Room: {{ $lecture->room ?? 'N/A' }}<br>
                                Program: {{ $lecture->instructorCourseAssignment->program->name ?? 'Unknown Program' }}
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-muted bg-white">No upcoming lectures for today.</li>
                    @endforelse
                </ul>
                <div class="card-footer bg-white text-end">
                    <span class="text-muted small">Current Time: {{ now()->setTimezone('Asia/Karachi')->format('h:i A') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection