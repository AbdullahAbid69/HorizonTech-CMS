@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Submit Query</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form style="width: 100%" action="{{ route('alunimi.query.store') }}" method="POST">
                @csrf

                <div class="col-lg-12 mt-3">
                    <label for="subject">Subject</label>
                    <input class="form-control" value="{{ old('subject') }}" type="text" name="subject" id="subject">
                    @error('subject')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-lg-12 mt-3">
                    <label for="query">Your Query</label>
                    <textarea class="form-control" name="query" id="query" rows="5">{{ old('query') }}</textarea>
                    @error('query')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                {{-- adminReply is usually filled later by admin, so we won't ask user to fill this --}}

                <div class="row mt-4">
                    <div class="col-2">
                        <input type="submit" value="Submit" class="btn btn-md btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection