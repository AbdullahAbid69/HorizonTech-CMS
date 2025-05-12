@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Alumni Queries</h3>
    </div>
    <div class="col-12 col-xl-4">
        <div class="justify-content-end d-flex">
            <a href="{{ route('alunimi.query.create') }}" class="btn btn-primary">Add Query</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Query</th>
                    <th>Admin Reply</th>
                    <th>Query Time</th>
                    <th>Reply Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($queries as $query)
                    <tr>
                        <td>{{ $query->subject }}</td>
                        <td>{{ Str::limit($query->query, 80) }}</td>
                        <td>
                            @if ($query->adminReply)
                                {{ $query->adminReply }}
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>{{ $query->created_at->format('d M Y, h:i A') }}</td>
                        <td>
                            {{ $query->adminReply ? $query->updated_at->format('d M Y, h:i A') : '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No queries submitted yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection