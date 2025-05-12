@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-10 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">My Uploaded Lecture Notes</h3>
    </div>
    <div class="col-12 col-xl-2 mb-4 mb-xl-0">
        <a class="btn btn-primary" href="{{ route("instructor.lectures.notes.create")}}">Add Lecture Notes</a>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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