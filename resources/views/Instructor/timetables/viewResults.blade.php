@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-10 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Students Results</h3>
    </div>
    <div class="col-12 col-xl-2 mb-4 mb-xl-0">
        <a class="btn btn-primary" id="exportToExcel">Export to Excel</a>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">


        <div class="table-responsive">
            <table class="table table-hover" id="resultsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Assignment Marks</th>
                        <th>Sessional Marks</th>
                        <th>Mids Marks</th>
                        <th>Finals Marks</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $student)

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ $student->user->name }}
                            </td>
                            <td>
                                {{ $student->assignmentMarks }}

                            </td>
                            <td>
                                {{ $student->sessionalMarks }}
                            </td>
                            <td>
                                {{ $student->midMarks }}
                            </td>
                            <td>
                                {{ $student->finalMarks }}
                            </td>
                            <td>
                                @if($student->status === 'Pass')
                                    <span class="badge bg-success rounded-pill px-3 py-2 text-white">{{ $student->status }}</span>
                                @elseif($student->status === 'Fail')
                                    <span class="badge bg-danger rounded-pill px-3 py-2  text-white">{{ $student->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $student->status ?? 'N/A' }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Student Found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        document.getElementById('exportToExcel').addEventListener('click', function () {
            var wb = XLSX.utils.table_to_book(document.getElementById('resultsTable'), { sheet: "Student Results" });
            XLSX.writeFile(wb, "StudentResults.xlsx");
        });
    </script>

@endsection