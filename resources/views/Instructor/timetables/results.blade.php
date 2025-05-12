@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Students Results</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <form action="{{ route('instructor.results.store') }}" method="POST">
            @csrf
            <input type="hidden" name="timetable_id" value="{{ $timetableId }}">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Assignment Marks</th>
                            <th>Sessional Marks</th>
                            <th>Mids Marks</th>
                            <th>Finals Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $student)
                            @php
                                $userId = $student->user->id;
                                $assignmentMark = $weightedAssignmentMarks[$userId]['weighted'] ?? 0;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{ $student->user->name }}
                                    <input type="hidden" name="results[{{ $index }}][user_id]" value="{{ $userId }}">
                                    @error("results.$index.user_id")
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control w-75" value="{{ $assignmentMark }}"
                                        name="results[{{ $index }}][assignmentMarks]">
                                    @error("results.$index.assignmentMarks")
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control w-75" placeholder="Sessionals"
                                        name="results[{{ $index }}][sessionalMarks]" required>
                                    @error("results.$index.sessionalMarks")
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control w-75" placeholder="Mids"
                                        name="results[{{ $index }}][midMarks]" required>
                                    @error("results.$index.midMarks")
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td>
                                    <input type="number" class="form-control w-75" placeholder="Finals"
                                        name="results[{{ $index }}][finalMarks]" required>
                                    @error("results.$index.finalMarks")
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Student Found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(count($students))
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Submit Results</button>
                </div>
            @endif
        </form>
    </div>
@endsection