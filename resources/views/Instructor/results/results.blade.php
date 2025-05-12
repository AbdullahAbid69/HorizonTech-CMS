@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-10 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Result Report</h3>
    </div>
    <div class="col-12 col-xl-2 mb-4 mb-xl-0">
        <a class="btn btn-primary" id="exportToExcel">Export to Excel</a>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <form method="GET" action="{{ route('instructor.result.student') }}">
            <div class="row mb-4">
                <div class="col-lg-6">
                    <label for="timetable_id">Timetable</label>
                    <select class="form-control" name="timetable_id" id="timetable_id" required>
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
                <table class="table table-hover" id="resultsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Assignment</th>
                            <th>Sessional</th>
                            <th>Mids</th>
                            <th>Finals</th>
                            <th>Total</th>
                            <th>Grade</th>
                            <th>GPA</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $index => $result)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $result->user->name }}</td>
                                <td>{{ $result->assignmentMarks }}</td>
                                <td>{{ $result->sessionalMarks }}</td>
                                <td>{{ $result->midMarks }}</td>
                                <td>{{ $result->finalMarks }}</td>
                                <td>{{ $result->totalMarks }}</td>
                                <td>{{ $result->grade }}</td>
                                <td>{{ $result->gpa }}</td>
                                <td>
                                    @if($result->status === 'Pass')
                                        <span class="badge bg-success">Pass</span>
                                    @elseif($result->status === 'Fail')
                                        <span class="badge bg-danger">Fail</span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        @endif
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        document.getElementById('exportToExcel').addEventListener('click', function () {
            var wb = XLSX.utils.table_to_book(document.getElementById('resultsTable'), { sheet: "Student Results" });
            XLSX.writeFile(wb, "StudentResults.xlsx");
        });
    </script>

@endsection