@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Student Promotes</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promotableStudents as $index => $student)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone ?? '-' }}</td>
                            <td><a class="btn btn-primary"
                                    href="{{route("admin.promote.student", ['id' => $student->id])}}">Promote</a></td>
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