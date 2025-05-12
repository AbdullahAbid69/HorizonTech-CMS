@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Notices</h3>
    </div>

@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Notice to</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>To All Students,Instructors,Alumini</td>
                    <td><a class="btn btn-primary" href="{{route("admin.notice.compose", ['scope' => "all"])}}">Send
                            Mail</a>
                    </td>
                </tr>
                <tr>
                    <td>To All Students</td>
                    <td><a class="btn btn-primary" href="{{route("admin.notice.compose", ['scope' => "students"])}}">Send
                            Mail</a>
                    </td>
                </tr>
                <tr>
                    <td>To All New Students</td>
                    <td><a class="btn btn-primary" href="{{route("admin.notice.compose", ['scope' => "newStudents"])}}">Send
                            Mail</a>
                    </td>
                </tr>
                <tr>
                    <td>To All New Instructors</td>
                    <td><a class="btn btn-primary" href="{{route("admin.notice.compose", ['scope' => "instructors"])}}">Send
                            Mail</a>
                    </td>
                </tr>
                <tr>
                    <td>To All New Alumini</td>
                    <td><a class="btn btn-primary" href="{{route("admin.notice.compose", ['scope' => "alumini"])}}">Send
                            Mail</a>
                    </td>
                </tr>
                <tr>
                    <td>To All Audience</td>
                    <td><a class="btn btn-primary"
                            href="{{route("admin.notice.compose", ['scope' => "allAudience"])}}">Send
                            Mail</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection