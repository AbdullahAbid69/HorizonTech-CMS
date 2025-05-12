@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Finance Report</h3>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="mt-3 mb-2" style="margin-left: auto;margin-right: 15px">
            <button id="downloadExcel" class="btn btn-success">Download Excel</button>
        </div>
    </div>
    <div class="row">
        <form action="{{ route('admin.finance.report') }}" method="GET" class="row" style="width: 100%">
            <div class="col-lg-4" style="margin-left: 20px">
                <label for="">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
            </div>
            <div class="col-lg-4">
                <label for="">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
            </div>
            <div class="col-lg-1 mt-4">
                <input type="submit" value="Filter" class="btn btn-primary">
            </div>
            <div class="col-lg-2 mt-4">
                <a href="{{ route('admin.finance.report') }}" class="btn btn-danger">Clear Filter</a>
            </div>
        </form>
    </div>
    <div class="table-responsive mt-3">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Program</th>
                    <th>Semester</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fees as $fee)
                    <tr>
                        <td>{{ $fee->user->name }}</td>
                        <td>{{ $fee->program->name }}</td>
                        <td>{{ $fee->user->studentsDetails->semester ?? 'N/A' }}</td>
                        <td>{{ $fee->amount ?? 'N/A' }}</td>
                        <td>{{ $fee->created_at->format('d M Y') }}</td>

                    </tr>
                @endforeach
                @if ($fees->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No Fee found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        $('#downloadExcel').click(function () {
            let table = document.querySelector('table');
            let workbook = XLSX.utils.table_to_book(table, { sheet: "Finance Report" });
            XLSX.writeFile(workbook, 'finance-report.xlsx');
        });
    </script>
@endsection