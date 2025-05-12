@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Edit Department</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form style="width: 100%" action="{{ route('admin.departments.update', $department->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-6">
                        <label for="name">Name</label>
                        <input class="form-control" value="{{ old('name', $department->name) }}" type="text" name="name"
                            id="name">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <label for="description">Description (optional)</label>
                        <input class="form-control" value="{{ old('description', $department->description) }}" type="text"
                            name="description" id="description">
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3 d-flex justify-content-start">
                    <div class="col-2">
                        <input type="submit" value="Update" class="btn btn-md btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection