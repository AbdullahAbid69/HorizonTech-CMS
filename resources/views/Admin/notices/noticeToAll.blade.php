@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Notice</h3>
    </div>

@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form style="width: 100%" action="{{ route('admin.notice.send') }}" method="POST">
                @csrf
                <input type="hidden" name="scope" value="{{$scope}}">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="name">Subject</label>
                        <input class="form-control" value="{{ old('subject') }}" type="text" name="subject" id="subject">
                        @error('subject')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-lg-6">
                        <label for="code">Message</label>
                        <input class="form-control" value="{{ old('message') }}" type="text" name="message" id="message">
                        @error('message')
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