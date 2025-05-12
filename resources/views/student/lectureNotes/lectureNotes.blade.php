@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Lecture Notes</h3>
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
                        <th>file</th>
                        <th>Description</th>
                        <th>Uploaded At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notes as $index => $note)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $note->timetable->instructorCourseAssignment->course->title }}</td>
                            <td>{{ $note->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($note->due_date)->format('d M Y') }}</td>
                            <td>
                                @if ($note->file_path)
                                    <a href="{{ asset($note->file_path) }}" target="_blank">Download</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $note->description ?? '-' }}</td>
                            <td>{{ $note->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No notes uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection