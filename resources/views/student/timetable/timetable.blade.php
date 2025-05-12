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


    <div class="table-responsive" style="min-height: 400px;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Instructor</th>
                    <th>Day</th>
                    <th>Time</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($timetables as $timetable)

                    <tr>
                        <td>{{ $timetable->instructorCourseAssignment->course->title }}</td>
                        <td>{{ $timetable->instructorCourseAssignment->instructor->user->name }}</td>
                        <td>{{ $timetable->day }}</td>
                        <td>{{ \Carbon\Carbon::parse($timetable->start_time)->format('H:i')}} -
                            {{ \Carbon\Carbon::parse($timetable->end_time)->format('H:i') }}
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