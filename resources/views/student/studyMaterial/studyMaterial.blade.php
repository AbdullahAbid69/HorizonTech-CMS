@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Study Material</h3>
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
                        <th>Description</th>
                        <th>File Path</th>
                        <th>Uploaded At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studyMaterials as $index => $studyMaterial)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $studyMaterial->timetable->instructorCourseAssignment->course->title }}</td>
                            <td>{{ $studyMaterial->title }}</td>
                            <td>{{ $studyMaterial->description ?? '-' }}</td>
                            <td>
                                @if ($studyMaterial->file_path)
                                    <a href="{{ asset($studyMaterial->file_path) }}" target="_blank">Download</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $studyMaterial->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Study Material uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection