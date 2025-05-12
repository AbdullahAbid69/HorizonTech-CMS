@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Assignments</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Course Title</th>
                        <th>Title</th>
                        <th>Due Date</th>
                        <th>Marks</th>
                        <th>Assignment file</th>
                        <th>Description</th>
                        <th>Uploaded At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $index => $assignment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $assignment->timetable->instructorCourseAssignment->course->title }}</td>

                            <td>{{ $assignment->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y') }}</td>
                            <td>{{ $assignment->marks }}</td>
                            <td>
                                @if ($assignment->file_path)
                                    <a href="{{ asset($assignment->file_path) }}" target="_blank">Download</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $assignment->description ?? '-' }}</td>
                            <td>{{ $assignment->created_at->diffForHumans() }}</td>
                            <td>@if (\Carbon\Carbon::now()->lte(\Carbon\Carbon::parse($assignment->due_date)))
                                <a href="{{ route('student.assignment.upload', ['id' => $assignment->id]) }}"
                                    class="btn btn-primary">Upload Assignment</a>
                            @else
                                    <span class="text-white badge bg-danger">Due Date Passed</span>
                                @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No assignments uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection