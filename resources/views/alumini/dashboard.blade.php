@extends('layout.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">🎓 Alumni Dashboard</h1>

        {{-- Upcoming Events --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">📅 Upcoming Events</h5>
            </div>
            <div class="card-body">
                @if($upcomingEvents->count())
                    <ul class="list-group list-group-flush">
                        @foreach($upcomingEvents as $event)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $event->title }}</strong><br>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y') }}</small>
                                </div>
                                <a href="{{route("alunimi.event.index")}}" class="btn btn-sm btn-outline-primary">View
                                    Details</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No upcoming events at the moment.</p>
                @endif
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning text-white">
                        <h6 class="mb-0">📈 Participation Over Months</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-danger text-white">
                        <h6 class="mb-0">📊 Event Types Distribution</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample data for line chart (Month vs Participants)
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [{
                    label: 'Participants',
                    data: [50, 70, 40, 90, 60],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Sample data for pie chart (Event types)
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Seminars', 'Workshops', 'Meetups'],
                datasets: [{
                    data: [12, 7, 9],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
            }
        });
    </script>
@endsection