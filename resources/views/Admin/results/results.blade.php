@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Results</h3>
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
                        <th>Sessional</th>
                        <th>Assignments</th>
                        <th>Mids</th>
                        <th>Final</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $index => $result)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $result->timetable->instructorCourseAssignment->course->title }}</td>
                            <td>{{ $result->sessionalMarks }}</td>
                            <td>{{ $result->assignmentMarks ?? '-' }}</td>
                            <td>{{ $result->midMarks }}</td>
                            <td>{{ $result->finalMarks }}</td>
                            <td>
                                @if($result->status === 'Pass')
                                    <span class="badge bg-success rounded-pill px-3 py-2 text-white">{{ $result->status }}</span>
                                @elseif($result->status === 'Fail')
                                    <span class="badge bg-danger rounded-pill px-3 py-2  text-white">{{ $result->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $result->status ?? 'N/A' }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No results uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection