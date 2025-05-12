@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Programs</h3>
    </div>
    <div class="col-12 col-xl-4">
        <div class="justify-content-end d-flex">
            <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">Add Program</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Program Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Duration (Semesters)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programs as $program)
                    <tr>
                        <td>{{ $program->name }}</td>
                        <td>{{ $program->code }}</td>
                        <td class="text-wrap" style="max-width: 250px;">{{ $program->description }}</td>
                        <td>{{ $program->duration_in_semesters }}</td>
                        <td>
                            <div class="d-flex align-items-center" style="gap: 10px">
                                <a href="{{ route('admin.programs.edit', ['id' => $program->id]) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="color: green"
                                         fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd"
                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.programs.destroy', ['id' => $program->id]) }}"
                                   onclick="return confirm('Are you sure you want to delete this program?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="color: red"
                                         fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 5h4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0V6H6v6.5a.5.5 0 0 1-1 0v-7z"/>
                                        <path fill-rule="evenodd"
                                              d="M14.5 3a1 1 0 0 1-1 1H13v9.5A1.5 1.5 0 0 1 11.5 15h-7A1.5 1.5 0 0 1 3 13.5V4h-.5a1 1 0 0 1 0-2h3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1h3a1 1 0 0 1 1 1zM4 4v9.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V4H4z"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
