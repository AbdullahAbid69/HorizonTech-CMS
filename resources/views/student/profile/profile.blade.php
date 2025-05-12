@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-10 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">User Profile</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <form action="{{route("student.profile.update")}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Profile Image --}}
                <div class="col-lg-12 text-center mb-4">
                    <div class="profile-image-wrapper mb-2">
                        <img id="profile-preview"
                            src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('images/default-profile.png') }}"
                            alt="Profile Image" class="img-thumbnail rounded-circle" width="150" height="150">
                    </div>
                    <input type="file" name="profile_image" id="profile_image" class="form-control-file" accept="image/*"
                        onchange="previewProfileImage(event)">
                    @error('profile_image')
                        <p class="text-danger mt-1">{{ $message }}</p>
                    @enderror
                </div> {{-- Name --}} <div class="col-lg-6 mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input class="form-control" value="{{ old('name', Auth::user()->name) }}" type="text" name="name"
                        id="name">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div> {{-- Email --}} <div class="col-lg-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input class="form-control" value="{{ old('email', Auth::user()->email) }}" type="email" name="email"
                        id="email">
                    @error('email')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div> {{-- Phone --}} <div class="col-lg-6 mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input class="form-control" value="{{ old('phone', Auth::user()->phone) }}" type="text" name="phone"
                        id="phone">
                    @error('phone')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function previewProfileImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                document.getElementById('profile-preview').src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection