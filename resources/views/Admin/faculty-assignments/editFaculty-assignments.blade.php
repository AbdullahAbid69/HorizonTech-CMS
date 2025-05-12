@extends('layout.app')

@section('topSection')
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Edit Assignment</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form action="{{ route('admin.faculty-assignments.update', $assignment->id) }}" method="POST" style="width: 100%">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Instructor -->
                    <div class="col-lg-6">
                        <label for="instructor_id">Instructor</label>
                        <select name="instructor_id" id="instructor_id" class="form-control">
                            <option value="">Select Instructor</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}" {{ $assignment->instructor_id == $instructor->id ? 'selected' : '' }}>
                                    {{ $instructor->user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('instructor_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Course -->
                    <div class="col-lg-6">
                        <label for="course_id">Course</label>
                        <select name="course_id" id="course_id" class="form-control">
                            <option value="">Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ $assignment->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Program -->
                    <div class="col-lg-6 mt-3">
                        <label for="program_id">Program</label>
                        <select name="program_id" id="program_id" class="form-control">
                            <option value="">Select Program</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->id }}" {{ $assignment->program_id == $program->id ? 'selected' : '' }}>
                                    {{ $program->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('program_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Semester -->
                    <div class="col-lg-6 mt-3">
                        <label for="semester">Semester</label>
                        <input type="number" name="semester" id="semester" class="form-control" min="1" value="{{ $assignment->semester }}">
                        @error('semester')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
