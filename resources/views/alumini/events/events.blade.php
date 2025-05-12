@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Alumni Events</h3>
    </div>

@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Fee</th>
                    <th>Description</th>
                    <th>Organizer</th>
                    <th>Status</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($events as $event)
                    <tr>
                        <td>{{ $event->title }} <br /><strong>Venue: </strong> {{ $event->venue }}</td>
                        <td>{{ $event->event_time }} - {{ $event->event_date }}</td>
                        <td>{{ $event->fee }}</td>
                        <td>{{ Str::limit($event->description, 50) }}</td>
                        <td>{{ $event->organizer_name }}<br />{{ $event->contact_email }}<br />{{ $event->contact_phone }}</td>
                        <td>{{ $event->status }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No alumni events available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection