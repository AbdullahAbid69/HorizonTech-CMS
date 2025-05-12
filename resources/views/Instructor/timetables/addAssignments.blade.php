@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Add Assignment</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form style="width: 100%" action="{{ route('instructor.assignments.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="timetable_id" value="{{ $timetable->id }}">

                <div class="row">
                    <div class="col-lg-6">
                        <label for="title">Assignment Title</label>
                        <input class="form-control" value="{{ old('title') }}" type="text" name="title" id="title" required>
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <label for="due_date">Due Date</label>
                        <input class="form-control" value="{{ old('due_date') }}" type="date" name="due_date" id="due_date"
                            required>
                        @error('due_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-12 mt-3">
                        <label for="description">Description (Optional)</label>
                        <textarea class="form-control" name="description" id="description"
                            rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="assignment_file">Upload Assignment (PDF only)</label>
                        <input class="form-control" type="file" accept=".pdf" name="assignment_file" id="assignment_file"
                            accept="application/pdf">
                        @error('assignment_file')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label for="due_date">Marks</label>
                        <input class="form-control" value="{{ old('marks') }}" type="number" name="marks" id="marks"
                            required>
                        @error('marks')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-2">
                        <input type="submit" value="Save Assignment" class="btn btn-md btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection