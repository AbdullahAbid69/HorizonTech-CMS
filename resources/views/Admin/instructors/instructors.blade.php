@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Instructors</h3>
    </div>
    <div class="col-12 col-xl-4">
        <div class="justify-content-end d-flex">
            <a href="{{ route('admin.instructors.create') }}" class="btn btn-primary">Add Instructor</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="table-responsive mt-3">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Qualification</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instructors as $instructor)
                    <tr>
                        <td>{{ $instructor->user->name }}</td>
                        <td>{{ $instructor->user->email }}</td>
                        <td>{{ $instructor->user->phone ?? 'N/A' }}</td>
                        <td>{{ $instructor->department->name ?? 'N/A' }}</td>
                        <td>{{ $instructor->designation ?? 'N/A' }}</td>
                        <td>{{ $instructor->final_qualification ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                {{-- Example Edit link if needed --}}
                                <a href="{{ route('admin.instructors.edit', $instructor->id) }}" class="text-success"
                                    style="margin-right: 5px">
                                    <i class="bi bi-pencil-square" style="font-size: 1.2rem;"></i>
                                </a>
                                <form action="{{ route('admin.instructors.delete', $instructor->id) }}" method="POST"
                                    style="display: inline-block;"
                                    onsubmit="return confirm('Are you sure you want to delete this course?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border: none; background: transparent; padding: 0;"
                                        title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="color: red"
                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 5h4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0V6H6v6.5a.5.5 0 0 1-1 0v-7z" />
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1h3a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1h-11z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if ($instructors->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No instructors found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection