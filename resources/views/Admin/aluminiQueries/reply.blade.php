@extends('layout.app')

@section('content')
    <h4>Query from: {{ $query->user->name ?? 'Unknown' }}</h4>

    <p><strong>Subject:</strong> {{ $query->subject }}</p>
    <p><strong>Query:</strong><br>{{ $query->query }}</p>

    @if($query->adminReply)
        <div class="alert alert-success">
            <strong>Already Replied:</strong><br>
            {{ $query->adminReply }}
        </div>
    @else
        <form action="{{ route('admin.queries.reply', $query->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="adminReply">Your Reply</label>
                <textarea class="form-control" name="adminReply" id="adminReply" rows="4" required></textarea>
            </div>
            <button class="btn btn-success mt-2" type="submit">Send Reply</button>
        </form>
    @endif

    <a href="{{ route('admin.queries.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection