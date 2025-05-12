@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Instructors</h3>
    </div>

@endsection

@section('content')
    <div class="table-responsive mt-3">
        <table class="table table-hover" id="studentTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Qualification</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($instructors as $instructor)
                    <tr>
                        <td>{{ $instructor->user->name }}</td>
                        <td>{{ $instructor->user->email }}</td>
                        <td>{{ $instructor->user->phone ?? 'N/A' }}</td>
                        <td>{{ $instructor->department->name ?? 'N/A' }}</td>
                        <td>{{ $instructor->designation ?? 'N/A' }}</td>
                        <td>{{ $instructor->final_qualification ?? 'N/A' }}</td>

                    </tr>
                @endforeach

                @if ($instructors->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No instructors found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <script>
        let table = new DataTable('#studentTable');
    </script>
@endsection