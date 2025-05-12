@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Edit Instructor</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form style="width: 100%" action="{{ route('admin.instructors.update', $instructor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Full Name -->
                    <div class="col-lg-6">
                        <label for="name">Full Name</label>
                        <input class="form-control" value="{{ old('name', $instructor->user->name) }}" type="text"
                            name="name" id="name">
                        @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-lg-6">
                        <label for="email">Email</label>
                        <input class="form-control" value="{{ old('email', $instructor->user->email) }}" type="email"
                            name="email" id="email">
                        @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-lg-6 mt-3">
                        <label for="phone">Phone</label>
                        <input class="form-control" value="{{ old('phone', $instructor->user->phone) }}" type="text"
                            name="phone" id="phone">
                        @error('phone') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <!-- Department -->
                    <div class="col-lg-6 mt-3">
                        <label for="department_id">Department</label>
                        <select name="department_id" id="department_id" class="form-control">
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $instructor->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <!-- Designation -->
                    <div class="col-lg-6 mt-3">
                        <label for="designation">Designation</label>
                        <input class="form-control" value="{{ old('designation', $instructor->designation) }}" type="text"
                            name="designation" id="designation">
                        @error('designation') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                    <!-- Final Qualification -->
                    <div class="col-lg-6 mt-3">
                        <label for="final_qualification">Final Qualification</label>
                        <input class="form-control"
                            value="{{ old('final_qualification', $instructor->final_qualification) }}" type="text"
                            name="final_qualification" id="final_qualification">
                        @error('final_qualification') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col-2">
                        <input type="submit" value="Update" class="btn btn-md btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection