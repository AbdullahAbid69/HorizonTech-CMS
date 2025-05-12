@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Courses</h3>
    </div>
    <div class="col-12 col-xl-4">
        <div class="justify-content-end d-flex">
            <a href="{{route("admin.courses.add")}}" class="btn btn-primary">Add Courses</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Credits</th>
                    <th>Prerequisites</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courses as $course)
                    <tr>
                        <td>{{ $course->code }}</td>
                        <td>{{ $course->title }}</td>
                        <td>{{ Str::limit($course->description, 50) }}</td>
                        <td>{{ $course->credit_hours }}</td>
                        <td>
                            @if ($course->prerequisites && count($course->prerequisites))
                                @php
                                    $prereqTitles = \App\Models\Course::whereIn('id', $course->prerequisites)->pluck('title')->toArray();
                                @endphp
                                {{ implode(', ', $prereqTitles) }}
                            @else
                                None
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center" style="gap: 10px">
                                <a href="{{ route('admin.courses.edit', $course->id) }}" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" style="color: green"
                                        fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd"
                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.courses.delete', $course->id) }}" method="POST"
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
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No courses available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection