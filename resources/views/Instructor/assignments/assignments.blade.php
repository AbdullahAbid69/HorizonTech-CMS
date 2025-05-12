@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-10 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">My Uploaded Assignments</h3>
    </div>
    <div class="col-12 col-xl-2 mb-4 mb-xl-0">

        <a class="btn btn-primary" href="{{ route("instructor.assignment.create.page")}}">Add Assignment</a>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Due Date</th>
                        <th>file</th>
                        <th>Description</th>
                        <th>Uploaded At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $index => $assignment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $assignment->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y') }}</td>
                            <td>
                                @if ($assignment->file_path)
                                    <a href="{{ asset($assignment->file_path) }}" target="_blank">Download</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $assignment->description ?? '-' }}</td>
                            <td>{{ $assignment->created_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('instructor.assignments.uploaded', ['id' => $assignment->id]) }}"
                                    class="btn btn-primary">View Assignments</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No assignments uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection