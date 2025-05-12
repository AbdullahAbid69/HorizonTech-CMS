@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Fees</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">


        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Semester</th>
                        <th>Date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fees as $index => $fee)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $fee->semester }}</td>
                            <td>{{ $fee->created_at->diffForHumans() }}</td>
                            <td>{{ $fee->amount ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No fee paid yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection