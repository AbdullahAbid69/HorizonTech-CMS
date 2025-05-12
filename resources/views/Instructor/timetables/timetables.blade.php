@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Class Timetables</h3>
    </div>
    <div class="col-12 col-xl-4">
        <div class="justify-content-end d-flex">

        </div>
    </div>
@endsection

@section('content')
    @php
        $groupedTimetables = $timetables->groupBy(function ($timetable) {
            return $timetable->instructorCourseAssignment->course->title . '|' .
                $timetable->instructorCourseAssignment->program->name . '|' .
                $timetable->instructorCourseAssignment->semester;
        });
    @endphp

    <div class="table-responsive" style="min-height: 400px;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Program / Semester</th>
                    <th>Schedule</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($groupedTimetables as $groupKey => $group)
                    @php
                        [$courseTitle, $programName, $semester] = explode('|', $groupKey);
                    @endphp
                    <tr>
                        <td>{{ $courseTitle }}</td>
                        <td>{{ $programName }} / {{ $semester }}</td>
                        <td>
                            @foreach ($group as $timetable)
                                <div>
                                    {{ $timetable->day }} -
                                    {{ \Carbon\Carbon::parse($timetable->start_time)->format('H:i') }} to
                                    {{ \Carbon\Carbon::parse($timetable->end_time)->format('H:i') }}
                                    (Room: {{ $timetable->room ?? 'N/A' }})
                                </div>
                            @endforeach
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                    id="dropdownMenuButton{{ $loop->index }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Manage
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $loop->index }}">
                                    <li class="border-bottom"><a class="dropdown-item"
                                            href="{{ route('instructor.assignments.create', ['timetable_id' => $group->first()->id]) }}">Add
                                            Assignment</a></li>
                                    <li class="border-bottom"><a class="dropdown-item"
                                            href="{{ route('instructor.lecture.notes.create', ['timetable_id' => $group->first()->id]) }}">Add
                                            Lecture Notes</a></li>
                                    <li class="border-bottom"><a class="dropdown-item"
                                            href="{{ route('instructor.study.material.create', ['timetable_id' => $group->first()->id]) }}">Add
                                            Study Materials</a></li>
                                    <li class="border-bottom"><a class="dropdown-item"
                                            href="{{route("instructor.notice.create", ['timetable_id' => $group->first()->id]) }}">Add
                                            Notice</a></li>
                                    <li class="border-bottom"><a class="dropdown-item"
                                            href="{{route("instructor.user.create", ['timetable_id' => $group->first()->id]) }}">View
                                            Students</a></li>
                                    <li class="border-bottom"><a class="dropdown-item"
                                            href="{{route("instructor.student.attendance", ['timetable_id' => $group->first()->id]) }}">
                                            Student Attendance</a></li>
                                    <li class="border-bottom"><a class="dropdown-item"
                                            href="{{route("instructor.student.report", ['timetable_id' => $group->first()->id]) }}">
                                            Attendance Report</a></li>
                                    <li class="border-bottom"><a class="dropdown-item"
                                            href="{{route("instructor.student.result", ['timetable_id' => $group->first()->id]) }}">
                                            Student Results</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No timetable entries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection