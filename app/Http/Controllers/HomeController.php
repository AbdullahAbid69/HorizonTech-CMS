<?php

namespace App\Http\Controllers;


use App\Models\Program;
use App\Models\StudentAttendance;
use App\Models\StudentResult;
use App\Models\StudentUserDetials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\StudentProgramFee;
use Carbon\Carbon;
use App\Models\AlumniEvent;
use App\Models\InstructorCourseAssignment;
use App\Models\Timetable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    private function calculateLetterGrade($percentage)
    {
        if ($percentage >= 90)
            return 'A+';
        if ($percentage >= 85)
            return 'A';
        if ($percentage >= 80)
            return 'A-';
        if ($percentage >= 75)
            return 'B+';
        if ($percentage >= 70)
            return 'B';
        if ($percentage >= 65)
            return 'B-';
        if ($percentage >= 60)
            return 'C+';
        if ($percentage >= 55)
            return 'C';
        if ($percentage >= 50)
            return 'C-';
        return 'F';
    }

    private function convertToGPA($letterGrade)
    {
        switch ($letterGrade) {
            case 'A+':
                return 4.0;
            case 'A':
                return 4.0;
            case 'A-':
                return 3.7;
            case 'B+':
                return 3.3;
            case 'B':
                return 3.0;
            case 'B-':
                return 2.7;
            case 'C+':
                return 2.3;
            case 'C':
                return 2.0;
            case 'C-':
                return 1.7;
            default:
                return 0.0;
        }
    }
    private function getAttendanceStatus($percentage)
    {
        if ($percentage >= 85)
            return 'Excellent';
        if ($percentage >= 75)
            return 'Good';
        if ($percentage >= 65)
            return 'Fair';
        if ($percentage >= 50)
            return 'Warning';
        return 'Critical';
    }
    public function index()
    {
        $role = Auth::user()->role;
        if ($role === "admin") {
            $totalStudents = User::where('role', 'student')->count();
            $totalInstructors = User::where('role', 'instructor')->count();
            $totalNewStudents = User::where('role', 'newStudent')->count();
            $totalAlumni = User::where('role', 'alumini')->count();
            $currentYear = Carbon::now()->year;
            $totalPayments = StudentProgramFee::whereYear('created_at', $currentYear)
                ->sum('amount');
            $upcomingEvents = AlumniEvent::where('status', 'upcoming')
                ->whereDate('event_date', '>=', Carbon::today())
                ->orderBy('event_date')
                ->take(5) // Limit to 5 upcoming events
                ->get();
            $admissionsPerMonth = User::whereIn('role', ['student', 'newStudent'])
                ->whereYear('created_at', now()->year)
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month');
            $monthlyAdmissions = [];
            for ($i = 1; $i <= 12; $i++) {
                $monthlyAdmissions[] = $admissionsPerMonth->get($i, 0);
            }
            return view('Admin.dashboard', compact(
                'totalStudents',
                'totalInstructors',
                'totalNewStudents',
                'totalAlumni',
                'totalPayments',
                'upcomingEvents',
                'monthlyAdmissions'
            ));
        } elseif ($role === "newStudent" || $role === "UnRegistered") {
            $role = Auth::user()->role;
            $application = StudentUserDetials::where('user_id', Auth::id())->first();

            $data = [
                'role' => $role,
                'application' => $application,
                'programs' => Program::all(), // Or Program::where('is_active', true)->get()
                'instructorsCount' => User::where('role', 'instructor')->count(),
                'studentsCount' => User::where('role', 'student')->count(),
            ];

            return view('newStudent.dashboard', $data);
            // return view('newStudent.dashboard', compact('role', 'application'));
        } elseif ($role === "student") {
            $studentId = Auth::id();
            $studentDetails = StudentUserDetials::with('program')->where('user_id', $studentId)->firstOrFail();

            // Current semester courses with assignments and attendance
            $currentTimetables = Timetable::with([
                'instructorCourseAssignment.course',
                'assignments' => function ($query) {
                    $query->where('due_date', '>=', now())
                        ->orderBy('due_date', 'asc');
                },
                'attendance' => function ($query) use ($studentId) {
                    $query->where('user_id', $studentId);
                }
            ])->whereHas('instructorCourseAssignment', function ($query) use ($studentDetails) {
                $query->where('program_id', $studentDetails->program_id)
                    ->where('semester', $studentDetails->semester);
            })->get()->map(function ($timetable) {
                // Calculate attendance percentage
                $attendanceCollection = $timetable->attendance ?? collect(); // Fallback to empty collection if null
                $totalClasses = $attendanceCollection->count();
                $presentClasses = $attendanceCollection->where('attendance', 'Present')->count();
                $attendancePercentage = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100) : 0;

                return [
                    'course' => $timetable->instructorCourseAssignment->course,
                    'timetable_id' => $timetable->id,
                    'assignments' => $timetable->assignments,
                    'attendance' => [
                        'total' => $totalClasses,
                        'present' => $presentClasses,
                        'percentage' => $attendancePercentage,
                        'status' => $this->getAttendanceStatus($attendancePercentage)
                    ]
                ];
            });

            // Previous semester grades with GPA calculation
            $previousSemester = max(1, $studentDetails->semester - 1); // Ensure semester doesn't go below 1

            $previousGrades = StudentResult::with(['timetable.instructorCourseAssignment.course'])
                ->whereHas('timetable.instructorCourseAssignment', function ($query) use ($studentDetails, $previousSemester) {
                    $query->where('program_id', $studentDetails->program_id)
                        ->where('semester', $previousSemester);
                })
                ->where('user_id', $studentId)
                ->get()
                ->map(function ($result) {
                    $totalMarks = ($result->assignmentMarks * 0.2) +
                        ($result->sessionalMarks * 0.2) +
                        ($result->midMarks * 0.25) +
                        ($result->finalMarks * 0.35);

                    $letterGrade = $this->calculateLetterGrade($totalMarks);
                    $gpa = $this->convertToGPA($letterGrade);

                    return [
                        'course' => $result->timetable->instructorCourseAssignment->course,
                        'marks' => [
                            'assignments' => $result->assignmentMarks,
                            'sessional' => $result->sessionalMarks,
                            'midterm' => $result->midMarks,
                            'final' => $result->finalMarks,
                            'total' => round($totalMarks, 2)
                        ],
                        'grade' => $letterGrade,
                        'gpa' => $gpa
                    ];
                });

            // Overall attendance summary
            $attendanceSummary = [
                'totalClasses' => $currentTimetables->sum('attendance.total'),
                'presentClasses' => $currentTimetables->sum('attendance.present'),
                'percentage' => $currentTimetables->avg('attendance.percentage')
            ];
            $upcomingAssignments = $currentTimetables->flatMap(function ($course) {
                return $course['assignments']->map(function ($assignment) {
                    return [
                        'title' => $assignment->title,
                        'due_date' => $assignment->due_date ? \Carbon\Carbon::parse($assignment->due_date) : null
                    ];
                });
            });
            $nearestAssignmentDue = $upcomingAssignments->pluck('due_date')->filter()->sort()->first();

            return view('student.dashboard', [
                'student' => $studentDetails,
                'currentCourses' => $currentTimetables,
                'previousGrades' => $previousGrades,
                'previousSemester' => $previousSemester,
                'semesterGPA' => $previousGrades->avg('gpa'),
                'attendanceSummary' => $attendanceSummary,
                'nearestAssignmentDue' => $nearestAssignmentDue
            ]);
        }
        // Add these methods to your controller
        elseif ($role === "alumini") {
            $upcomingEvents = AlumniEvent::where('status', 'upcoming')
                ->whereDate('event_date', '>=', Carbon::today())
                ->orderBy('event_date')
                ->take(5) // Limit to 5 upcoming events
                ->get();
            return view('alumini.dashboard', compact("upcomingEvents"));
        } elseif ($role === "instructor") {
            $instructorId = Auth::id();
            $assignedCourses = InstructorCourseAssignment::with('course')
                ->where('instructor_id', $instructorId)
                ->get();
            $totalCourses = $assignedCourses->count();

            $assignedPrograms = InstructorCourseAssignment::with('program')
                ->where('instructor_id', $instructorId)
                ->get();
            $totalPrograms = $assignedPrograms->count();

            $now = Carbon::now('Asia/Karachi');
            $currentDay = $now->format('l'); // e.g. Monday, Tuesday
            $currentTime = $now->format('H:i:s');

            // Get only upcoming lectures (start time is after the current time)
            $upcomingLectures = Timetable::whereHas('instructorCourseAssignment', function ($query) use ($instructorId) {
                $query->where('instructor_id', $instructorId);
            })
                ->where('day', $currentDay)
                ->where('start_time', '>=', $currentTime) // Ensure it's an upcoming lecture
                ->with(['instructorCourseAssignment.course', 'instructorCourseAssignment.program'])
                ->orderBy('start_time')
                ->get();

            $totalLectures = $upcomingLectures->count();

            return view('instructor.dashboard', compact('assignedCourses', 'totalCourses', 'assignedPrograms', 'totalPrograms', 'upcomingLectures', 'totalLectures'));
        }
        return view('home');
    }
    public function logoutUser()
    {
        // dd("e");
        Auth::logout();
        return redirect('/');
    }
}