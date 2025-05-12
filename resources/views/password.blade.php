@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Change Password</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="{{ route('password.change') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" id="current_password"
                        class="form-control @error('current_password') is-invalid @enderror" required>
                    @error('current_password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password"
                        class="form-control @error('new_password') is-invalid @enderror" required>
                    @error('new_password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label for="new_password_confirmation">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                        class="form-control @error('new_password_confirmation') is-invalid @enderror" required>
                    @error('new_password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection