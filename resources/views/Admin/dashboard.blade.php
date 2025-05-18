@extends('layout.app')

@section('content')
<div class="container-fluid px-0" style="margin-top:0 !important; top:0 !important;">
    <h1 class="mb-2">Admin Dashboard</h1>

    <style>
        .stat-card { transition: box-shadow 0.3s, transform 0.3s; }
        .stat-card:hover { box-shadow: 0 0 24px 0 #007bff33; transform: translateY(-4px) scale(1.03); }
        .card { border-radius: 1rem; }
        .card-header { font-weight: 600; letter-spacing: 0.5px; }
    </style>

    <div class="row g-0 flex-nowrap overflow-auto" style="margin-left:0; margin-right:0;">
        <div class="col-12 col-md-auto" style="flex: 0 0 20%; max-width: 20%; padding-left:1px; padding-right:1px;">
            <div class="card text-white bg-primary mb-1 text-center stat-card" style="border-radius: 0; min-height: 100px; font-size: 1.2rem; margin-bottom:20px;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/people-fill.svg" alt="Students Icon" style="width:40px; height:40px; margin-bottom:10px; filter: invert(1);">
                    <h5 class="card-title text-white">Students</h5>
                    <p class="card-text display-6">{{ $totalStudents }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-auto" style="flex: 0 0 20%; max-width: 20%; padding-left:1px; padding-right:1px;">
            <div class="card text-white bg-success mb-1 text-center stat-card" style="border-radius: 0; min-height: 100px; font-size: 1.2rem; margin-bottom:20px;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/person-badge-fill.svg" alt="Instructors Icon" style="width:40px; height:40px; margin-bottom:10px; filter: invert(1);">
                    <h5 class="card-title text-white">Instructors</h5>
                    <p class="card-text display-6">{{ $totalInstructors }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-auto" style="flex: 0 0 20%; max-width: 20%; padding-left:1px; padding-right:1px;">
            <div class="card text-white bg-info mb-1 text-center stat-card" style="border-radius: 0; min-height: 100px; font-size: 1.2rem; margin-bottom:20px;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/mortarboard-fill.svg" alt="Alumni Icon" style="width:40px; height:40px; margin-bottom:10px; filter: invert(1);">
                    <h5 class="card-title text-white">Alumni</h5>
                    <p class="card-text display-6">{{ $totalAlumni }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-auto" style="flex: 0 0 20%; max-width: 20%; padding-left:1px; padding-right:1px;">
            <div class="card text-white bg-warning mb-1 text-center stat-card" style="border-radius: 0; min-height: 100px; font-size: 1.2rem; margin-bottom:20px;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/file-earmark-person-fill.svg" alt="Applications Icon" style="width:40px; height:40px; margin-bottom:10px; filter: invert(1);">
                    <h5 class="card-title text-white">New Applications</h5>
                    <p class="card-text display-6">{{ $totalNewStudents }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-auto" style="flex: 0 0 20%; max-width: 20%; padding-left:1px; padding-right:1px;">
            <div class="card text-white bg-dark mb-1 text-center stat-card" style="border-radius: 0; min-height: 100px; font-size: 1.2rem; margin-bottom:20px;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <img src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/icons/cash-stack.svg" alt="Payments Icon" style="width:40px; height:40px; margin-bottom:10px; filter: invert(1);">
                    <h5 class="card-title text-white">Payments ({{ now()->year }})</h5>
                    <p class="card-text display-6">Rs.{{ number_format($totalPayments, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header bg-primary text-white">Monthly Admissions Trend</div>
                <div class="card-body"><canvas id="admissionsChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header bg-success text-white">Payments Over Months</div>
                <div class="card-body"><canvas id="paymentsAreaChart"></canvas></div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card shadow h-100">
                <div class="card-header bg-info text-white">Student Distribution by Program</div>
                <div class="card-body"><canvas id="programPieChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow h-100">
                <div class="card-header bg-warning text-white">Gender Ratio</div>
                <div class="card-body"><canvas id="genderPieChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow h-100">
                <div class="card-header bg-dark text-white">Instructor by Department</div>
                <div class="card-body"><canvas id="instructorDeptBarChart"></canvas></div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header bg-secondary text-white">Alumni Growth by Year</div>
                <div class="card-body"><canvas id="alumniDonutChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header bg-danger text-white">Students Per Semester</div>
                <div class="card-body"><canvas id="studentsSemesterBarChart"></canvas></div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header bg-primary text-white">New Applications Per Month</div>
                <div class="card-body"><canvas id="applicationsMonthBarChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6">
            <!-- Upcoming Events as a styled list -->
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Helper to show 'No data to show' overlay
    function showNoDataMessage(canvasId, message = 'No data to show') {
        const canvas = document.getElementById(canvasId);
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.font = '18px Arial';
        ctx.textAlign = 'center';
        ctx.fillStyle = '#888';
        ctx.fillText(message, canvas.width / 2, canvas.height / 2);
    }

    // Utility to check if all values are zero or array is empty
    function isEmptyData(arr) {
        if (!arr || arr.length === 0) return true;
        return arr.every(v => !v || v === 0);
    }

    // Monthly Admissions Line
    const admissionsData = @json($monthlyAdmissions);
    if (isEmptyData(admissionsData)) {
        showNoDataMessage('admissionsChart');
    } else {
        new Chart(document.getElementById('admissionsChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Admissions',
                    data: admissionsData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: '#007bff',
                    borderWidth: 3,
                    pointBackgroundColor: '#007bff',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}}}
        });
    }

    // Payments Area Chart (replace with real data)
    const paymentsData = @json($monthlyPayments ?? []);
    if (isEmptyData(paymentsData)) {
        showNoDataMessage('paymentsAreaChart');
    } else {
        new Chart(document.getElementById('paymentsAreaChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Payments',
                    data: paymentsData,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: '#28a745',
                    borderWidth: 3,
                    pointBackgroundColor: '#28a745',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}}}
        });
    }

    // Program Pie
    const programLabels = @json(array_keys($programStats->toArray()));
    const programValues = @json(array_values($programStats->toArray()));
    if (isEmptyData(programValues)) {
        showNoDataMessage('programPieChart');
    } else {
        new Chart(document.getElementById('programPieChart'), {
            type: 'pie',
            data: {
                labels: programLabels,
                datasets: [{
                    data: programValues,
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#6c757d', '#e83e8c', '#dc3545', '#6610f2', '#fd7e14', '#20c997'],
                }]
            },
            options: {responsive:true, plugins:{legend:{position:'bottom'}}}
        });
    }

    // Gender Doughnut
    const genderLabels = @json(array_keys($genderStats->toArray()));
    const genderValues = @json(array_values($genderStats->toArray()));
    if (isEmptyData(genderValues)) {
        showNoDataMessage('genderPieChart');
    } else {
        new Chart(document.getElementById('genderPieChart'), {
            type: 'doughnut',
            data: {
                labels: genderLabels,
                datasets: [{
                    data: genderValues,
                    backgroundColor: ['#007bff', '#e83e8c', '#6c757d'],
                }]
            },
            options: {responsive:true, plugins:{legend:{position:'bottom'}}}
        });
    }

    // Instructor by Department Bar
    const deptLabels = @json(array_keys($instructorDeptStats->toArray()));
    const deptValues = @json(array_values($instructorDeptStats->toArray()));
    if (isEmptyData(deptValues)) {
        showNoDataMessage('instructorDeptBarChart');
    } else {
        new Chart(document.getElementById('instructorDeptBarChart'), {
            type: 'bar',
            data: {
                labels: deptLabels,
                datasets: [{
                    label: 'Instructors',
                    data: deptValues,
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#6c757d', '#e83e8c', '#dc3545', '#6610f2', '#fd7e14', '#20c997'],
                    borderRadius: 6
                }]
            },
            options: {responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}}}
        });
    }

    // Alumni Donut (replace with real alumni per year data)
    const alumniLabels = @json(isset($alumniYearStats) ? array_keys($alumniYearStats->toArray()) : []);
    const alumniValues = @json(isset($alumniYearStats) ? array_values($alumniYearStats->toArray()) : []);
    if (isEmptyData(alumniValues)) {
        showNoDataMessage('alumniDonutChart');
    } else {
        new Chart(document.getElementById('alumniDonutChart'), {
            type: 'doughnut',
            data: {
                labels: alumniLabels,
                datasets: [{
                    data: alumniValues,
                    backgroundColor: ['#6610f2', '#fd7e14', '#20c997', '#007bff', '#dc3545'],
                }]
            },
            options: {responsive:true, plugins:{legend:{position:'bottom'}}}
        });
    }

    // Students Per Semester (replace with real data)
    const semesterLabels = @json(isset($studentsPerSemester) ? array_keys($studentsPerSemester) : []);
    const semesterValues = @json(isset($studentsPerSemester) ? array_values($studentsPerSemester) : []);
    if (isEmptyData(semesterValues)) {
        showNoDataMessage('studentsSemesterBarChart');
    } else {
        new Chart(document.getElementById('studentsSemesterBarChart'), {
            type: 'bar',
            data: {
                labels: semesterLabels,
                datasets: [{
                    label: 'Students',
                    data: semesterValues,
                    backgroundColor: '#007bff',
                    borderRadius: 6
                }]
            },
            options: {responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}}}
        });
    }

    // New Applications Per Month (replace with real data)
    const appLabels = @json(isset($applicationsPerMonth) ? array_keys($applicationsPerMonth) : []);
    const appValues = @json(isset($applicationsPerMonth) ? array_values($applicationsPerMonth) : []);
    if (isEmptyData(appValues)) {
        showNoDataMessage('applicationsMonthBarChart');
    } else {
        new Chart(document.getElementById('applicationsMonthBarChart'), {
            type: 'bar',
            data: {
                labels: appLabels,
                datasets: [{
                    label: 'Applications',
                    data: appValues,
                    backgroundColor: '#ffc107',
                    borderRadius: 6
                }]
            },
            options: {responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}}}
        });
    }
</script>
@endsection