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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applications as $application)
                    <tr>
                        <td>{{ $application->name }}</td>
                        <td>{{ $application->studentsDetails->program->name ?? 'N/A' }}</td>
                        <td>{{ $application->email ?? 'N/A' }}</td>
                        <td>{{ $application->phone ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex align-items-center" style="gap: 10px">
                                <a type="button" class=""
                                    href="{{route("admin.application.detail", ['id' => $application->id])}}" {{--
                                    data-bs-toggle="modal" data-bs-target="#modal-{{ $application->id }}" --}}>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        style="color: #3F3E91" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                        <path
                                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                    </svg>
                                </a>

                                <a href="{{ route('admin.applications.approve', $application->id) }}" title="approve">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        style="color: green " class="bi bi-bookmark-check" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                        <path
                                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
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

@endsection