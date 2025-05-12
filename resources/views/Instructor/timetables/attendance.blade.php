@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Students Attendance</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <form action="{{ route('instructor.attendance.store') }}" method="POST">
            <input type="hidden" name="timetableId" value="{{$timetableId}}">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <label for="">Date</label>
                    <input type="date" class="form-control" name="date" id="">
                    @error("date")
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mt-4">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $student->user->name }}</td>
                                <td>

                                    <div class="form-check form-check-inline d-flex">
                                        <input class="form-check-input" type="radio" name="attendance[{{ $student->user_id }}]"
                                            id="present_{{ $student->user_id }}" value="Present" checked>
                                        <label class="form-check-label" for="present_{{ $student->user_id }}">Present</label>
                                    </div>
                                    <div class="form-check form-check-inline d-flex">
                                        <input class="form-check-input" type="radio" name="attendance[{{ $student->user_id }}]"
                                            id="absent_{{ $student->user_id }}" value="Absent">
                                        <label class="form-check-label" for="absent_{{ $student->user_id }}">Absent</label>
                                    </div>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No Student Found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary mt-3">Submit Attendance</button>
            </div>
        </form>
    </div>
@endsection