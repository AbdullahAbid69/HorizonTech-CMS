@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-10 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Attendance Report</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <form method="GET" action="{{ route('student.attendance.report') }}">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <label for="timetable_id">Timetable</label>
                    <select class="form-control" name="timetable_id" required>
                        <option disabled selected>Select a timetable</option>
                        @foreach ($timetables as $item)
                            <option value="{{ $item->id }}" {{ request('timetable_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->instructorCourseAssignment->course->code }}
                            </option>
                        @endforeach
                    </select>
                    @error('timetable_id')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-lg-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        @if(isset($results))
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $index => $record)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $record->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</td>
                                <td>
                                    @if($record->attendance === 'Present')
                                        <span class="badge bg-success">Present</span>
                                    @elseif($record->attendance === 'Absent')
                                        <span class="badge bg-danger">Absent</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $record->attendance ?? 'N/A' }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No attendance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection