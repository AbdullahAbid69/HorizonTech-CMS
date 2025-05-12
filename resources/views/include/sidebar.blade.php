<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @if (Auth::user()->role === "admin")
        <li class="nav-item @if (Route::currentRouteName() === 'home') active @endif href="{{ route('home') }} >
            <a class="nav-link" href="{{ route('home') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.courses.index', 'admin.courses.add','admin.courses.edit']) ? 'active' : '' }}">
                    <a class="nav-link "
                       href="{{ route('admin.courses.index') }}">
                        <i class="bi bi-journal-bookmark menu-icon"></i>
                        <span class="menu-title ms-2">Courses</span>
                    </a>
                </li>
                <li class="nav-item  {{ in_array(Route::currentRouteName(), ['admin.programs.index', 'admin.programs.create','admin.programs.edit']) ? 'active' : '' }}" >
                    <a class="nav-link" href="{{ route('admin.programs.index') }}">
                        <i class="bi bi-diagram-3 menu-icon"></i>
                        <span class="menu-title">Programs</span>
                    </a>
                </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.instructors.index', 'admin.instructors.create','admin.instructors.edit']) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.instructors.index') }}">
                        <i class="bi bi-person-badge menu-icon"></i>
                        <span class="menu-title">Instructors</span>
                    </a>
                </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.faculty-assignments.index', 'admin.faculty-assignments.create','admin.faculty-assignments.edit']) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.faculty-assignments.index') }}">
                        <i class="bi bi-person-check menu-icon"></i>
                        <span class="menu-title">Faculty Assignments</span>
                    </a>
                </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.departments.index', 'admin.departments.create','admin.departments.edit']) ? 'active' : '' }}">

                    <a class="nav-link" href="{{ route('admin.departments.index') }}">
                        <i class="bi bi-building menu-icon"></i>
                        <span class="menu-title">Departments</span>
                    </a>
                </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.alumni_events.index', 'admin.alumni_events.create','admin.alumni_events.edit']) ? 'active' : '' }}">

                    <a class="nav-link" href="{{ route('admin.alumni_events.index') }}">
                        <i class="bi bi-calendar-event menu-icon"></i>
                        <span class="menu-title">Alumni Events</span>
                    </a>
                </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.timetables.index', 'admin.timetables.create']) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.timetables.index') }}">
                        <i class="bi bi-calendar-week menu-icon"></i>
                        <span class="menu-title">Time Tables</span>
                    </a>
                </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.finance.report']) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.finance.report') }}">
                        <i class="bi bi-file-earmark-text menu-icon"></i>
                        <span class="menu-title">Financial Report</span>
                    </a>
                </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.application.index', 'admin.application.detail']) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.application.index') }}">
                        <i class="bi bi-file-earmark-text menu-icon"></i>
                        <span class="menu-title">Applications</span>
                    </a>
                </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.students.index', 'admin.students.results']) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.students.index') }}">
                        <i class="bi bi-mortarboard menu-icon"></i>
                        <span class="menu-title">Students Details</span>
                    </a>
                </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.notice.page',"admin.notice.compose"]) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.notice.page') }}">
                        <i class="bi bi-megaphone menu-icon"></i>
                        <span class="menu-title">Notice</span>
                    </a>
                </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.student.promote']) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.student.promote') }}">
                        <i class="bi bi-arrow-up-circle menu-icon"></i>
                        <span class="menu-title">Student Promote</span>
                    </a>
                </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.queries.index','admin.queries.show']) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.queries.index') }}">
                        <i class="bi bi-file-earmark-plus menu-icon"></i>
                        <span class="menu-title">Alumini Queries</span>
                    </a>
                </li>
                <li class="nav-item {{ in_array(Route::currentRouteName(), ['admin.instructions',"admin.instructions.create"]) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.instructions') }}">
                        <i class="bi bi-file-earmark-plus menu-icon"></i>
                        <span class="menu-title">Instruction</span>
                    </a>
                </li>
                {{-- || Auth::user()->role ==="UnRegistered" --}}
            @elseif (Auth::user()->role === "newStudent" )
            <li class="nav-item @if (Route::currentRouteName() === 'home') active @endif href="{{ route('home') }} >
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['newStudent.application.index','newStudent.application.detail']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('newStudent.application.index') }}">
                    <i class="bi bi-file-earmark-plus menu-icon"></i>
                    <span class="menu-title">Applications</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['newStudent.instruction']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('newStudent.instruction') }}">
                    <i class="bi bi-file-earmark-plus menu-icon"></i>
                    <span class="menu-title">Instruction</span>
                </a>
            </li>
            <li class="nav-item @if (Route::currentRouteName() === 'newStudent.instructor') active @endif href="{{ route('home') }} >
                <a class="nav-link" href="{{ route('newStudent.instructor') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Faculty</span>
                </a>
            </li>
            <li class="nav-item @if (Route::currentRouteName() === 'newStudent.program') active @endif href="{{ route('home') }} >
                <a class="nav-link" href="{{ route('newStudent.program') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Program Offered</span>
                </a>
            </li>
           
            @elseif (Auth::user()->role === "UnRegistered" )
            <li class="nav-item @if (Route::currentRouteName() === 'home') active @endif href="{{ route('home') }} >
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item @if (Route::currentRouteName() === 'newStudent.instruction.page') active @endif href="{{ route('home') }} >
                <a class="nav-link" href="{{ route('newStudent.instruction.page') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Instruction</span>
                </a>
            </li>
            <li class="nav-item @if (Route::currentRouteName() === 'newStudent.instructor.page') active @endif href="{{ route('home') }} >
                <a class="nav-link" href="{{ route('newStudent.instructor.page') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Faculty</span>
                </a>
            </li>
            <li class="nav-item @if (Route::currentRouteName() === 'newStudent.program.page') active @endif href="{{ route('home') }} >
                <a class="nav-link" href="{{ route('newStudent.program.page') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Programs Offered</span>
                </a>
            </li>
        @elseif (Auth::user()->role === "instructor")
            <li class="nav-item @if (Route::currentRouteName() === 'home') active @endif href="{{ route('home') }} >
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['instructor.timetables.index','instructor.notice.create','instructor.user.create',"instructor.send.mail","instructor.student.attendance","instructor.student.report","instructor.student.result"]) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('instructor.timetables.index') }}">
                    <i class="bi bi-calendar-week menu-icon"></i>
                    <span class="menu-title">Timetable</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['instructor.assignments.index','instructor.assignments.create','instructor.assignments.upload']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('instructor.assignments.index') }}">
                    <i class="bi bi-card-checklist menu-icon"></i>
                    <span class="menu-title">Assignments</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['instructor.study.material.index','instructor.study.material.create']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('instructor.study.material.index') }}">
                    <i class="bi bi-journal-text menu-icon"></i>
                    <span class="menu-title">Study Material</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['instructor.lecture.index','instructor.lecture.notes.create']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('instructor.lecture.index') }}">
                    <i class="bi bi-stickies menu-icon"></i>
                    <span class="menu-title">Lecture Notes</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['instructor.result.student']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('instructor.result.student') }}">
                    <i class="bi bi-stickies menu-icon"></i>
                    <span class="menu-title">Results</span>
                </a>
            </li>
        @elseif (Auth::user()->role === "student")
            <li class="nav-item  @if (Route::currentRouteName() === 'home') active @endif href="{{ route('home') }} >
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['student.timetables.index']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('student.timetables.index') }}">
                    <i class="bi bi-calendar3 menu-icon"></i>
                    <span class="menu-title">Time Table</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['student.assignment.index']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('student.assignment.index') }}">
                    <i class="bi bi-card-list menu-icon"></i>
                    <span class="menu-title">Assignment</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['student.study.index']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('student.study.index') }}">
                    <i class="bi bi-journals menu-icon"></i>
                    <span class="menu-title">Study Material</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['student.notes.index']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('student.notes.index') }}">
                    <i class="bi bi-journal-richtext menu-icon"></i>
                    <span class="menu-title">Lecture Notes</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['student.result.index']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('student.result.index') }}">
                    <i class="bi bi-bar-chart-line menu-icon"></i>
                    <span class="menu-title">Result</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['student.student.fee']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('student.student.fee') }}">
                    <i class="bi bi-cash-coin menu-icon"></i>
                    <span class="menu-title">Fee</span>
                </a>
            </li>
            <li class="nav-item {{ in_array(Route::currentRouteName(), ['student.attendance.report']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('student.attendance.report') }}">
                    <i class="bi bi-cash-coin menu-icon"></i>
                    <span class="menu-title">Attendance Report</span>
                </a>
            </li>
        @elseif (Auth::user()->role === "alumini")
            <li class="nav-item @if (Route::currentRouteName() === 'home') active @endif href="{{ route('home') }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item @if (Route::currentRouteName() === 'alunimi.event.index') active @endif href="{{ route('alunimi.event.index') }}>
                <a class="nav-link" href="{{ route('alunimi.event.index') }}">
                    <i class="bi bi-calendar-event menu-icon"></i>
                    <span class="menu-title">Events</span>
                </a>
            </li>
            <li class="nav-item @if (Route::currentRouteName() === 'alunimi.results') active @endif href="{{ route('alunimi.results') }}>
                <a class="nav-link" href="{{ route('alunimi.results') }}">
                    <i class="bi bi-calendar-event menu-icon"></i>
                    <span class="menu-title">Results</span>
                </a>
            </li>
        @endif
    </ul>
</nav>