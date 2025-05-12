@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Add Course</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form style="width: 100%" action="{{ route('admin.courses.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <label for="code">Course Code</label>
                        <input class="form-control" value="{{ old('code') }}" type="text" name="code" id="code">
                        @error('code')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <label for="title">Course Title</label>
                        <input class="form-control" value="{{ old('title') }}" type="text" name="title" id="title">
                        @error('title')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="credit_hours">Credit Hours</label>
                        <input class="form-control" value="{{ old('credit_hours', 3) }}" type="number" name="credit_hours" id="credit_hours">
                        @error('credit_hours')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="prerequisites">Prerequisites (hold Ctrl to select multiple)</label>
                        <select class="form-control" name="prerequisites[]" id="prerequisites" multiple>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" @if(is_array(old('prerequisites')) && in_array($course->id, old('prerequisites'))) selected @endif>
                                    {{ $course->title }} ({{ $course->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('prerequisites')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-12 mt-3">
                        <label for="description">Description (optional)</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-2">
                        <input type="submit" value="Save" class="btn btn-md btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
