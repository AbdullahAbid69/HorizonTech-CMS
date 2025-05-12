@extends("layout.app")

@section("topSection")
    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
        <h3 class="font-weight-bold">Student Applications</h3>
    </div>
    <div class="col-12 col-xl-4">
        <div class="justify-content-end d-flex">
            <a href="{{ route('newStudent.app.comp') }}" class="btn btn-primary">Complete Application</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Email</th>
                    <th>Program</th>
                    <th>Mobile</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" colspan="6">No Applications Found</td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
                $(document).ready(function () {
                    function initializeModalHandlers() {
                        $(document).off('click', '.openModalBtn');
                        $(document).on('click', '.openModalBtn', function (e) {
                            e.preventDefault();
                        });
                    }
                });
    </script>
@endsection