@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Instructor DashBoard</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12">
                <div class="card text-white bg-primary mb-3 text-center">
                    <div class="card-body">
                        <h5 class="card-title text-white">Courses Allotted</h5>
                        <p class="card-text display-6">{{ $totalCourses }}</p>
                    </div>
                </div>

                <div class="card my-4">
                    <div class="card-header">
                        <strong>Assigned Courses</strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse ($assignedCourses as $assignment)
                            <li class="list-group-item">
                                {{ $assignment->course->title ?? 'Unknown Course' }} ({{ $assignment->course->code ?? 'N/A' }})
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No courses assigned.</li>
                        @endforelse
                    </ul>
                </div>

            </div>
            <div class="col-md-12">
            <div class="card text-white bg-primary mb-3 text-center">
                    <div class="card-body">
                        <h5 class="card-title text-white">Programs Allotted</h5>
                        <p class="card-text display-6">{{ $totalPrograms }}</p>
                    </div>
                </div>

                <div class="card my-4">
                    <div class="card-header">
                        <strong>Assigned Programs</strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse ($assignedPrograms as $assignment)
                            <li class="list-group-item">
                                {{ $assignment->program->name ?? 'Unknown Course' }} ({{ $assignment->program->code ?? 'N/A' }})
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No courses assigned.</li>
                        @endforelse
                    </ul>
                </div>
            </div>   
        </div>   
        <div class="col-md-6">
        <div class="card text-white bg-primary mb-3 text-center">
    <div class="card-body">
        <h5 class="card-title text-white">Upcoming Lectures</h5>
        <p class="card-text display-6">{{ $totalLectures ?? $upcomingLectures->count() }}</p>
    </div>
</div>

<div class="card my-4">
    <div class="card-header">
        <strong>Today's Upcoming Lectures ({{ \Carbon\Carbon::now()->format('l') }})</strong>
    </div>
    <ul class="list-group list-group-flush">
        @forelse ($upcomingLectures as $lecture)
            <li class="list-group-item">
                <strong>{{ $lecture->instructorCourseAssignment->course->title ?? 'Unknown Course' }}</strong><br>
                <span class="text-muted">
                    Time: {{ \Carbon\Carbon::parse($lecture->start_time)->format('h:i A') }} -
                        {{ \Carbon\Carbon::parse($lecture->end_time)->format('h:i A') }},
                    Room: {{ $lecture->room ?? 'N/A' }}<br>
                    Program: {{ $lecture->instructorCourseAssignment->program->name ?? 'Unknown Program' }}
                    <p>Current Time: {{ \Carbon\Carbon::now()->format('h:i A') }}</p>
                </span>
            </li>
        @empty
            <li class="list-group-item text-muted">No upcoming lectures for today.</li>
        @endforelse
    </ul>
</div>

        </div>
    </div>
    
@endsection