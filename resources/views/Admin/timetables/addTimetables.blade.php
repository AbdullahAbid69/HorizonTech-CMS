@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Add Timetable Entry</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form style="width: 100%" action="{{ route('admin.timetables.store') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="col-lg-6">
                        <label for="instructor_course_assignment_id">Course Assignment</label>
                        <select class="form-control" name="instructor_course_assignment_id" id="instructor_course_assignment_id">
                            <option value="">Select Instructor-Course</option>
                            @foreach($assignments as $assignment)
                                <option
                                    value="{{ $assignment->id }}"
                                    data-instructor-id="{{ $assignment->instructor_id }}"
                                    data-program-id="{{ $assignment->program_id }}"
                                    data-semester="{{ $assignment->semester }}"
                                    {{ old('instructor_course_assignment_id') == $assignment->id ? 'selected' : '' }}
                                >
                                    {{ $assignment->course->title ?? 'No Title' }} - {{ $assignment->instructor->user->name ?? 'No Name' }} ({{ $assignment->program->name ?? 'No Program' }}, Semester {{ $assignment->semester }})
                                </option>
                            @endforeach
                        </select>

                        @error('instructor_course_assignment_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <label for="day">Day</label>
                        <select class="form-control" name="day" id="day">
                            <option value="">Select Day</option>
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                        @error('day')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="start_time">Start Time</label>
                        <input class="form-control" value="{{ old('start_time') }}" type="time" name="start_time" id="start_time">
                        @error('start_time')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="end_time">End Time</label>
                        <input class="form-control" value="{{ old('end_time') }}" type="time" name="end_time" id="end_time">
                        @error('end_time')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="room">Room</label>
                        <input class="form-control" value="{{ old('room') }}" type="text" name="room" id="room">
                        @error('room')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-12 mt-3">
                        <label for="notes">Notes (optional)</label>
                        <textarea class="form-control" name="notes" id="notes" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-2">
                        <div class="col-12 mt-3" id="conflict-message"></div>
                        <input type="submit" value="Save" class="btn btn-md btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
        <script>
            function gatherTimetableData() {
                const selectedOption = $('#instructor_course_assignment_id option:selected');
                const assignmentId = selectedOption.val();

                // Get custom data attributes or fetch from server if needed
                let instructorId = selectedOption.data('instructor-id');
                let programId = selectedOption.data('program-id');
                let semester = selectedOption.data('semester');

                return {
                    instructor_id: instructorId,
                    program_id: programId,
                    semester: semester,
                    day: $('#day').val(),
                    start_time: $('#start_time').val(),
                    end_time: $('#end_time').val(),
                    room: $('#room').val()
                };
            }

            function checkConflict() {
    const selectedOption = $('#instructor_course_assignment_id option:selected');
    const instructorId = selectedOption.data('instructor-id');
    const programId = selectedOption.data('program-id');
    const semester = selectedOption.data('semester');
    const day = $('#day').val();
    const start_time = $('#start_time').val();
    const end_time = $('#end_time').val();
    const room = $('#room').val();

    // Basic check to avoid sending empty data
    if (!instructorId || !programId || !semester || !day ||
        !isValidTime(start_time) || !isValidTime(end_time) || !room) {
        $('#conflict-message').html('');
        return;
    }

    const formData = new FormData();
    formData.append('instructor_id', instructorId);
    formData.append('program_id', programId);
    formData.append('semester', semester);
    formData.append('day', day);
    formData.append('start_time', start_time);
    formData.append('end_time', end_time);
    formData.append('room', room.toString());
    formData.append('_token', '{{ csrf_token() }}');

    // Debug log to verify values
    for (let pair of formData.entries()) {
        console.log(pair[0]+ ': ' + pair[1]);
    }

    $.ajax({
        url: '{{ route("admin.timetables.checkConflicts") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $('#conflict-message').html('<div class="text-success">No conflicts found.</div>');
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                let html = '<div class="text-danger"><ul>';
                for (const key in errors) {
                    html += `<li>${errors[key]}</li>`;
                }
                html += '</ul></div>';
                $('#conflict-message').html(html);
            } else {
                $('#conflict-message').html('<div class="text-danger">Unexpected error occurred.</div>');
            }
        }
    });
}


            function isValidTime(time) {
                return /^([01]\d|2[0-3]):([0-5]\d)$/.test(time);
            }
            $('#instructor_course_assignment_id, #day, #start_time, #end_time, #room').on('change', checkConflict);
        </script>
@endsection
