@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Students Uploaded Assignments</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="table-responsive">

            <form action="{{ route('instructor.assignment.grade') }}" method="POST">
                @csrf
                <input type="hidden" name="assignment_id" value="{{ $assignmentId }}">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>File</th>
                            <th>Uploaded At</th>
                            <th>Marks & Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $index => $student)
                            @php
                                $upload = $uploads[$student->id] ?? null;
                            @endphp
                            <tr class="{{ $upload->file_path ? 'table-success' : 'table-danger' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $student->name }}</td>
                                <td>
                                    @if ($upload && $upload->file_path)
                                        <a href="{{ asset($upload->file_path) }}" target="_blank">Download</a>
                                    @else
                                        Not Submitted
                                    @endif
                                </td>
                                <td>{{ $upload ? $upload->created_at->format('d M Y H:i') : '-' }}</td>
                                <td>
                                    @if ($upload && $upload->marks !== null && $upload->remarks !== null)
                                        <div class="d-flex">
                                            <strong>Marks:</strong> {{ $upload->marks }} &nbsp;
                                            <strong>Remarks:</strong> {{ $upload->remarks }}
                                        </div>
                                    @else
                                        <div class="d-flex">
                                            <input type="number" class="form-control" style="width: 30%"
                                                name="data[{{ $student->id }}][marks]" placeholder="marks" min="0"
                                                value="{{ $upload->marks ?? 0 }}" {{ !$upload ? '' : '' }}>

                                            <input type="text" name="data[{{ $student->id }}][remarks]"
                                                style="width: 70%; margin-left: 2px" class="form-control" placeholder="remarks"
                                                value="{{ $upload && $upload->file_path ? ($upload->remarks ?? '') : 'Assignment Not Uploaded' }}">
                                        </div>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary mt-3">Save Marks</button>
            </form>
        </div>
    </div>
@endsection