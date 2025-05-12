@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-2">
            <div class="card text-white bg-primary mb-3 text-center">
                <div class="card-body">
                    <h5 class="card-title text-white">Students</h5>
                    <p class="card-text display-6">{{ $totalStudents }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-white bg-success mb-3 text-center">
                <div class="card-body">
                    <h5 class="card-title text-white">Instructors</h5>
                    <p class="card-text display-6">{{ $totalInstructors }}</p>
                </div>
            </div>
        </div>


        <div class="col-md-2">
            <div class="card text-white bg-info mb-3 text-center">
                <div class="card-body">
                    <h5 class="card-title text-white">Alumni</h5>
                    <p class="card-text display-6">{{ $totalAlumni }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3 text-center">
                <div class="card-body">
                    <h5 class="card-title text-white">New Applications</h5>
                    <p class="card-text display-6">{{ $totalNewStudents }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-dark mb-3 text-center">
                <div class="card-body">
                    <h5 class="card-title text-white">Payments ({{ now()->year }})</h5>
                    <p class="card-text display-6">Rs.{{ number_format($totalPayments, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
        <div class="card">
    <div class="card-header bg-primary text-white">
        Upcoming Alumni Events
    </div>
    <div class="card-body p-0">
        @if ($upcomingEvents->count())
            <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner" style="min-height: 200px;">
                    @foreach ($upcomingEvents as $index => $event)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="p-3 text-center"> {{-- Text centered here --}}
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="mb-1"><strong>Venue:</strong> {{ $event->venue }}</p>
                                <p class="mb-1"><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</p>
                                <p class="mb-1"><strong>Time:</strong> {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($upcomingEvents->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif
            </div>
        @else
            <div class="p-3 text-center">
                <p class="text-muted">No upcoming events.</p>
            </div>
        @endif
    </div>
</div>

        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    Monthly Admissions ({{ now()->year }})
                </div>
                <div class="card-body">
                    <canvas id="admissionsChart" height="200"></canvas>
                </div>
            </div>
        </div>        
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('admissionsChart').getContext('2d');
    const admissionsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                     'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Admissions',
                data: @json($monthlyAdmissions),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection