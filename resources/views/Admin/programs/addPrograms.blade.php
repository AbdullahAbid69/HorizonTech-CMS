@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Add Program</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form style="width: 100%" action="{{ route('admin.programs.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <label for="name">Program Name</label>
                        <input class="form-control" value="{{ old('name') }}" type="text" name="name" id="name">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <label for="code">Program Code</label>
                        <input class="form-control" value="{{ old('code') }}" type="text" name="code" id="code">
                        @error('code')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label for="duration_in_semesters">Duration (in Semesters)</label>
                        <input class="form-control" value="{{ old('duration_in_semesters', 8) }}" type="number"
                            name="duration_in_semesters" id="duration_in_semesters" min="1">
                        @error('duration_in_semesters')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label for="duration_in_semesters">Fee Per Semester</label>
                        <input class="form-control" value="{{ old('fee_per_semester') }}" type="number"
                            name="fee_per_semester" id="fee_per_semester" min="0">
                        @error('fee_per_semester')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-12 mt-3">
                        <label for="description">Description (optional)</label>
                        <textarea class="form-control" name="description" id="description"
                            rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4 d-flex justify-content-start">
                    <div class="col-2">
                        <input type="submit" value="Save" class="btn btn-md btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection