@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Add Lecture Notes</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form style="width: 100%" action="{{ route('instructor.lecture.notes.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                {{-- <input type="hidden" name="timetable_id" value="{{ $timetable->id }}"> --}}

                <div class="row">
                    <div class="col-lg-6">
                        <label for="title">TimeTable</label>
                        {{-- <input class="form-control" value="{{ old('title') }}" type="text" name="title" id="title"
                            required> --}}
                        <select class="form-control" name="timetable_id" aria-label="Default select example">
                            <option disabled selected>Open this select menu</option>
                            @foreach ($timetables as $item)
                                <option value="{{$item->id}}"> {{$item->instructorCourseAssignment->course->code}}</option>
                            @endforeach
                        </select>
                        @error('timetable_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-lg-6">
                        <label for="title">Lecture Title</label>
                        <input class="form-control" value="{{ old('title') }}" type="text" name="title" id="title" required>
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-lg-6 ">
                        <label for="assignment_file">Upload Lecture (PDF only)</label>
                        <input class="form-control" type="file" accept=".pdf" name="lecture_file" id="assignment_file"
                            accept="application/pdf">
                        @error('assignment_file')
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


                </div>

                <div class="row mt-4">
                    <div class="col-2">
                        <input type="submit" value="Save Notes" class="btn btn-md btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection