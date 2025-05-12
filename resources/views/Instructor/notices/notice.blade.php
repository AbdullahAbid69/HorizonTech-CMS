@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">My Uploaded Notice</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>scope</th>
                        {{-- <th>Description</th> --}}
                        <th>Uploaded At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notices as $index => $notice)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $notice->title }}</td>
                            <td>{{ $notice->content }}</td>
                            <td>{{ $notice->scope }}</td>
                            <td>{{ $notice->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No Notices uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection