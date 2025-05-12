@extends('layout.app')

@section('content')
    <h3>All Queries</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alumni</th>
                <th>Subject</th>
                <th>Query</th>
                <th>Reply</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($queries as $query)
                <tr>
                    <td>{{ $query->user->name ?? 'N/A' }}</td>
                    <td>{{ $query->subject }}</td>
                    <td>{{ $query->query }}</td>
                    <td>{{ $query->adminReply ?? 'Not replied' }}</td>
                    <td>
                        <a href="{{ route('admin.queries.show', $query->id) }}" class="btn btn-sm btn-primary">Reply</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection