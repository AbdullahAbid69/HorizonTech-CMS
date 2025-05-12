@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Students</h3>
    </div>
    <div class="col-12 col-xl-4">
    </div>
@endsection

@section('content')
    <div class="table-responsive">
        <table id="studentTable" class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Program</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->studentsDetails->program->name ?? 'N/A' }}</td>
                        <td>{{ $student->studentsDetails->semester ?? 'N/A' }}</td>
                        <td>
                            @if($student->status == 'active')
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Blocked</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center" style="gap: 10px">
                                <a href="{{ route('admin.students.results', ['id' => $student->id]) }}" title="show Results">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-code" viewBox="0 0 16 16">
                                        <path
                                            d="M5.854 4.854a.5.5 0 1 0-.708-.708l-3.5 3.5a.5.5 0 0 0 0 .708l3.5 3.5a.5.5 0 0 0 .708-.708L2.707 8zm4.292 0a.5.5 0 0 1 .708-.708l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L13.293 8z" />
                                    </svg>
                                </a>
                                {{-- Block or Unblock --}}
                                @if($student->status == 'active')
                                    <a href="{{ route('admin.students.block', ['id' => $student->id]) }}"
                                        onclick="return confirm('Are you sure you want to block this student?')"
                                        title="Block Student">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="color: orange"
                                            fill="currentColor" class="bi bi-person-dash" viewBox="0 0 16 16">
                                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM2 14s-1 0-1-1 1-4 5-4 5 4 5 4-1 1-1 1H2z" />
                                            <path fill-rule="evenodd"
                                                d="M11.5 8a.5.5 0 0 1 .5.5V10h2a.5.5 0 0 1 0 1h-2v1.5a.5.5 0 0 1-1 0V11h-2a.5.5 0 0 1 0-1h2V8.5a.5.5 0 0 1 .5-.5z" />
                                        </svg>
                                    </a>
                                @else
                                    <a href="{{ route('admin.students.unblock', ['id' => $student->id]) }}"
                                        onclick="return confirm('Are you sure you want to unblock this student?')"
                                        title="Unblock Student">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="color: green"
                                            fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
                                            <path
                                                d="M15.854 5.146a.5.5 0 0 0-.708 0L10.5 9.793 8.354 7.646a.5.5 0 1 0-.708.708l2.5 2.5a.5.5 0 0 0 .708 0l5-5a.5.5 0 0 0 0-.708z" />
                                            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM2 14s-1 0-1-1 1-4 5-4 5 4-1 1-1 1H2z" />
                                        </svg>
                                    </a>
                                @endif

                                {{-- Delete --}}
                                <form action="{{ route('admin.students.destroy', ['id' => $student->id]) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this student?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border: none; background: none; padding: 0;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="color: red"
                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 5h4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0V6H6v6.5a.5.5 0 0 1-1 0v-7z" />
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9.5A1.5 1.5 0 0 1 11.5 15h-7A1.5 1.5 0 0 1 3 13.5V4h-.5a1 1 0 0 1 0-2h3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1h3a1 1 0 0 1 1 1zM4 4v9.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V4H4z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{--
    <script>
        let table = new DataTable('#studentTable');
    </script> --}}
@endsection