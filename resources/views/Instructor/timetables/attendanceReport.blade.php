@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Attendance Summary</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="table-responsive">
            <table class="table table-hover mt-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Present Days</th>
                        <th>Total Classes</th>
                        <th>Attendance %</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendanceData as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data['student']->user->name }}</td>
                            <td>{{ $data['present_days'] }}</td>
                            <td>{{ $data['total_classes'] }}</td>
                            <td>{{ $data['percentage'] }}%</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No attendance data available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection