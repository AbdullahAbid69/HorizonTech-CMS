@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Add Instruction</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <form style="width: 100%" action="{{ route('admin.instructions.save') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <label for="instruction">Instruction Content</label>
                        <textarea class="form-control" name="instruction" id="instruction"
                            rows="3">{{ old('instruction') }}</textarea>
                        @error('instruction')
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