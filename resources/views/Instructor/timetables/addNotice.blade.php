@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Add Lecture Notes</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form style="width: 100%" action="{{ route('instructor.notice.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="timetable_id" value="{{ $timetableId}}">

                <div class="row">
                    <div class="col-lg-6">
                        <label for="title"> Subject</label>
                        <input class="form-control" value="{{ old('subject') }}" type="text" name="subject" id="subject"
                            required>
                        @error('subject')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-lg-12 ">
                        <label for="description">Message</label>
                        <textarea class="form-control" name="message" row="4" id="message">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-2">
                        <input type="submit" value="Save Notice" class="btn btn-md btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection