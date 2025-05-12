@include("include.header")
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include("include.topNav")
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">

        @include("include.sidebar")
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="row">
                            @yield("topSection")
                            {{-- <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                                <h3 class="font-weight-bold">Welcome Aamir</h3>
                                <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span
                                        class="text-primary">3 unread alerts!</span></h6>
                            </div>
                            <div class="col-12 col-xl-4">
                                <div class="justify-content-end d-flex">
                                    <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                        <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button"
                                            id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="true">
                                            <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right"
                                            aria-labelledby="dropdownMenuDate2">
                                            <a class="dropdown-item" href="#">January - March</a>
                                            <a class="dropdown-item" href="#">March - June</a>
                                            <a class="dropdown-item" href="#">June - August</a>
                                            <a class="dropdown-item" href="#">August - November</a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @yield("content")
                                {{-- <h4 class="card-title">Hoverable Table</h4> --}}
                                {{-- <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Product</th>
                                                <th>Sale</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Jacob</td>
                                                <td>Photoshop</td>
                                                <td class="text-danger"> 28.76% <i class="ti-arrow-down"></i></td>
                                                <td><label class="badge badge-danger">Pending</label></td>
                                            </tr>
                                            <tr>
                                                <td>Messsy</td>
                                                <td>Flash</td>
                                                <td class="text-danger"> 21.06% <i class="ti-arrow-down"></i></td>
                                                <td><label class="badge badge-warning">In progress</label></td>
                                            </tr>
                                            <tr>
                                                <td>John</td>
                                                <td>Premier</td>
                                                <td class="text-danger"> 35.00% <i class="ti-arrow-down"></i></td>
                                                <td><label class="badge badge-info">Fixed</label></td>
                                            </tr>
                                            <tr>
                                                <td>Peter</td>
                                                <td>After effects</td>
                                                <td class="text-success"> 82.00% <i class="ti-arrow-up"></i></td>
                                                <td><label class="badge badge-success">Completed</label></td>
                                            </tr>
                                            <tr>
                                                <td>Dave</td>
                                                <td>53275535</td>
                                                <td class="text-success"> 98.05% <i class="ti-arrow-up"></i></td>
                                                <td><label class="badge badge-warning">In progress</label></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.
                        Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a>
                        from BootstrapDash. All rights reserved.</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i
                            class="ti-heart text-danger ml-1"></i></span>
                </div>
            </footer> --}}
            <!-- partial -->
        </div>
    </div>
    <!-- page-body-wrapper ends -->
</div>
@include("include.footer")