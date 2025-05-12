@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Programs</h3>
    </div>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-hover" id="studentTable">
            <thead>
                <tr>
                    <th>Program Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Duration (Semesters)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programs as $program)
                    <tr>
                        <td>{{ $program->name }}</td>
                        <td>{{ $program->code }}</td>
                        <td class="text-wrap" style="max-width: 250px;">{{ $program->description }}</td>
                        <td>{{ $program->duration_in_semesters }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        let table = new DataTable('#studentTable');
    </script>
@endsection