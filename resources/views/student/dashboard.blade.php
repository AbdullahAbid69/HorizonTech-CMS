@extends('layout.app')

@section('content')
    <div class="container-fluid">
        <!-- Dashboard Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Student Dashboard</h1>
            <div class="d-flex">
                <span class="badge badge-primary p-2 mr-2">
                    <i class="fas fa-graduation-cap"></i> {{ $student->program->name }}
                </span>
                <span class="badge badge-info p-2">
                    <i class="fas fa-calendar-alt"></i> Semester {{ $student->semester }}
                </span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <!-- Attendance Summary -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Overall Attendance</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $attendanceSummary['percentage'] }}%
                                </div>
                                <div class="mt-2 text-xs">
                                    <span
                                        class="{{ $attendanceSummary['percentage'] >= 75 ? 'text-success' : 'text-danger' }}">
                                        <i
                                            class="fas fa-{{ $attendanceSummary['percentage'] >= 75 ? 'check' : 'exclamation' }}-circle"></i>
                                        {{ $attendanceSummary['presentClasses'] }} of
                                        {{ $attendanceSummary['totalClasses'] }} classes
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current GPA -->
            <div class="col-xl-3 col-md-6 mb-4">
                
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Semester {{ $previousSemester }} GPA</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($semesterGPA, 2) }}
                                </div>
                                <div class="mt-2 text-xs">
                                    @if($semesterGPA >= 3.5)
                                        <span class="text-success"><i class="fas fa-award"></i> Excellent</span>
                                    @elseif($semesterGPA >= 3.0)
                                        <span class="text-primary"><i class="fas fa-thumbs-up"></i> Good</span>
                                    @elseif($semesterGPA >= 2.0)
                                        <span class="text-warning"><i class="fas fa-info-circle"></i> Needs Improvement</span>
                                    @else
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Warning</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-star fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Assignments -->
            
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{route("student.assignment.index")}}" style="text-decoration: none">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Upcoming Assignments</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $currentCourses->sum(function ($course) {
        return count($course['assignments']); }) }}
                                </div>
                                <div class="mt-2 text-xs">
                                    @if($nearestAssignmentDue)
                                        <span class="text-info">
                                            <i class="fas fa-clock"></i>
                                            Next due: {{ $nearestAssignmentDue->diffForHumans() }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-clock"></i>
                                            No upcoming assignments
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            </div>

            <!-- Current Courses -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Current Courses</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ count($currentCourses) }}
                                </div>
                                <div class="mt-2 text-xs">
                                    <span class="text-warning">
                                        <i class="fas fa-book-open"></i>
                                        {{ $student->semester }}th Semester
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Courses with Attendance -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary">
                        <h6 class="m-0 font-weight-bold text-white">Current Courses & Attendance</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th class="text-center">Attendance</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Upcoming Assignments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($currentCourses as $course)
                                        <tr>
                                            <td>{{ $course['course']->code }}</td>
                                            <td>{{ $course['course']->title }}</td>
                                            <td class="text-center">
                                                <div class="progress position-relative" style="height: 25px;">
                                                    <div class="progress-bar 
                                                                                                                        @if($course['attendance']['percentage'] >= 85) bg-success
                                                                                                                        @elseif($course['attendance']['percentage'] >= 75) bg-primary
                                                                                                                        @elseif($course['attendance']['percentage'] >= 65) bg-warning
                                                                                                                            @else bg-danger
                                                                                                                        @endif"
                                                        role="progressbar"
                                                        style="width: {{ $course['attendance']['percentage'] }}%"
                                                        aria-valuenow="{{ $course['attendance']['percentage'] }}"
                                                        aria-valuemin="0" aria-valuemax="100">
                                                        <span class="position-absolute"
                                                            style="top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-weight: bold;">
                                                            {{ $course['attendance']['percentage'] }}%
                                                        </span>
                                                    </div>
                                                </div>
                                                <small class="text-muted">
                                                    {{ $course['attendance']['present'] }}/{{ $course['attendance']['total'] }}
                                                    classes
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge 
                                                                                                                    @if($course['attendance']['percentage'] >= 85) badge-success
                                                                                                                    @elseif($course['attendance']['percentage'] >= 75) badge-primary
                                                                                                                    @elseif($course['attendance']['percentage'] >= 65) badge-warning
                                                                                                                        @else badge-danger
                                                                                                                    @endif">
                                                    {{ $course['attendance']['status'] }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if(count($course['assignments']) > 0)
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($course['assignments'] as $assignment)
<li class="mb-1">
    <a href="#" data-toggle="tooltip" 
       title="Due: {{ $assignment->due_date ? \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') : 'No due date' }}">
        {{ Str::limit($assignment->title, 20) }}
        @if($assignment->due_date)
        <small class="text-danger">
            ({{ \Carbon\Carbon::parse($assignment->due_date)->diffForHumans() }})
        </small>
        @endif
    </a>
</li>
@endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted">No assignments</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Previous Semester Results -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-success">
                        <h6 class="m-0 font-weight-bold text-white">Semester {{ $previousSemester }} Results</h6>
                    </div>
                    <div class="card-body">
                        @if(count($previousGrades) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Course Code</th>
                                            <th>Course Name</th>
                                            <th class="text-center">Assignments</th>
                                            <th class="text-center">Sessional</th>
                                            <th class="text-center">Midterm</th>
                                            <th class="text-center">Final</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Grade</th>
                                            <th class="text-center">GPA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($previousGrades as $grade)
                                            <tr>
                                                <td>{{ $grade['course']->code }}</td>
                                                <td>{{ $grade['course']->title }}</td>
                                                <td class="text-center">{{ $grade['marks']['assignments'] ?? '-' }}</td>
                                                <td class="text-center">{{ $grade['marks']['sessional'] ?? '-' }}</td>
                                                <td class="text-center">{{ $grade['marks']['midterm'] ?? '-' }}</td>
                                                <td class="text-center">{{ $grade['marks']['final'] ?? '-' }}</td>
                                                <td class="text-center font-weight-bold">{{ $grade['marks']['total'] ?? '-' }}</td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge 
                                                                                                                                                        @if($grade['grade'] == 'A' || $grade['grade'] == 'A-') badge-success
                                                                                                                                                        @elseif($grade['grade'] == 'B+' || $grade['grade'] == 'B') badge-primary
                                                                                                                                                        @elseif($grade['grade'] == 'B-' || $grade['grade'] == 'C+') badge-info
                                                                                                                                                        @elseif($grade['grade'] == 'C' || $grade['grade'] == 'C-') badge-warning
                                                                                                                                                            @else badge-danger
                                                                                                                                                        @endif">
                                                        {{ $grade['grade'] }}
                                                    </span>
                                                </td>
                                                <td class="text-center font-weight-bold">{{ $grade['gpa'] }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-light">
                                            <td colspan="8" class="text-right font-weight-bold">Semester GPA:</td>
                                            <td class="text-center font-weight-bold">{{ number_format($semesterGPA, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No grades available for Semester {{ $previousSemester }}</h5>
                                <p class="text-muted">Results will be published soon</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Initialize popovers
            $('[data-toggle="popover"]').popover();
        });
    </script>

    <style>
        .progress {
            background-color: #e9ecef;
            border-radius: 0.25rem;
        }

        .progress-bar {
            position: relative;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .badge {
            font-size: 0.85em;
            padding: 0.5em 0.75em;
        }
    </style>
@endsection