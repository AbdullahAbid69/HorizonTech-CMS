<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="{{route("home")}}">
            <img src="{{asset("altImages/Horizon Tech.jpg")}}" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{route("home")}}">
            <img src="{{asset("altImages/Horizon Tech.jpg")}}" alt="logo" style="height: 30px; width: auto;" />
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
                <div class="input-group">

                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    {{Auth::user()->name}}
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    @if (Auth::user()->role === "admin")
                        <a href="{{route("admin.profile")}}" class="dropdown-item">
                            <i class="ti-settings text-primary"></i>
                            Profile
                        </a>
                    @elseif (Auth::user()->role === "newStudent")
                        <a href="{{route("newStudent.profile")}}" class="dropdown-item">
                            <i class="ti-settings text-primary"></i>
                            Profile
                        </a>
                    @elseif (Auth::user()->role === "alumini")
                        <a href="{{route("alunimi.profile")}}" class="dropdown-item">
                            <i class="ti-settings text-primary"></i>
                            Profile
                        </a>
                    @elseif (Auth::user()->role === "student")
                        <a href="{{route("student.profile")}}" class="dropdown-item">
                            <i class="ti-settings text-primary"></i>
                            Profile
                        </a>
                    @elseif (Auth::user()->role === "instructor")
                        <a href="{{route("instructor.profile")}}" class="dropdown-item">
                            <i class="ti-settings text-primary"></i>
                            Profile
                        </a>
                    @endif
                    <a href="{{route("password.page")}}" class="dropdown-item">
                        <i class="ti-power-off text-primary"></i>
                        Change Password
                    </a>
                    <a href="{{route("logout.user")}}" class="dropdown-item">
                        <i class="ti-power-off text-primary"></i>
                        Logout
                    </a>

                </div>
            </li>
            {{-- <li class="nav-item nav-settings d-none d-lg-flex">
                <a class="nav-link" href="#">
                    <i class="icon-ellipsis"></i>
                </a>
            </li> --}}
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>