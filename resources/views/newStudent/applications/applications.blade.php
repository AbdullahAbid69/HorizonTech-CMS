@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Student Applications</h3>
    </div>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Email</th>
                    <th>Program</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applications as $application)
                    <tr>
                        <td>{{ $application->name }}</td>
                        <td>{{ $application->studentsPrograms->program->name ?? 'N/A' }}</td>
                        <td>{{ $application->email ?? 'N/A' }}</td>
                        <td>{{ $application->mobile ?? 'N/A' }}</td>
                        <td>
                            <span class="badge badge-warning text-white">Pending</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center" style="gap: 10px">
                                <a type="button" class=""
                                    href="{{route("newStudent.application.detail", ['id' => $application->id])}}" {{--
                                    data-bs-toggle="modal" data-bs-target="#modal-{{ $application->id }}" --}}>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        style="color: #3F3E91" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                        <path
                                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                    </svg>
                                </a>

                            </div>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No applications available.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
    <script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
                $(document).ready(function () {
                    function initializeModalHandlers() {
                        $(document).off('click', '.openModalBtn');
                        $(document).on('click', '.openModalBtn', function (e) {
                            e.preventDefault();
                        });
                    }
                });
    </script>
@endsection