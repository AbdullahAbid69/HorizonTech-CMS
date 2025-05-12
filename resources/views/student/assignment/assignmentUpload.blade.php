@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Upload Assignments</h3>
    </div>
@endsection

@section('content')
    <div class="col-12 mt-3">
        <div class="row">
            <div class="col-12">
                <span>
                    <p style="font-size: 15px"><span class="" style="font-weight: bolder">Assignment
                            Title:&nbsp;</span>{{$assignment->title}}</p>
                </span>
            </div>
            <form action="{{route("student.assignment.save")}}" style="width: 100%" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="col-6 mt-3">
                    <input type="hidden" name="assignmentId" value="{{$assignment->id}}">
                    <label for="" class="form-label">Upload Assignment (PDF Only)</label>
                    <input type="file" name="file" class="form-control" id="">
                    @error("file")
                        <p class="text-danger">{{$message}}</p>

                    @enderror
                </div>
                <input type="submit" value="Upload" class="btn btn-primary mt-3">
            </form>
        </div>
    </div>
@endsection