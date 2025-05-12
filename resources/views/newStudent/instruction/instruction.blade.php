@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Instruction</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Instruction</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($instructions as $index => $instruction)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $instruction->instruction }}</td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">No Instruction uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection