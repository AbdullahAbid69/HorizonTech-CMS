<?php

namespace App\Http\Controllers;

use App\Models\StudentAttendance;
use App\Models\StudentResult;
use App\Models\StudentUserDetials;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAttendanceController extends Controller
{
    public function markAttendance(Request $request)
    {
        $timetableId = $request->query('timetable_id');
        $timetables = Timetable::whereHas('instructorCourseAssignment')
            ->where('id', $timetableId) // Add this line to filter by timetable id
            ->with([
                'instructorCourseAssignment.instructor.user',
                'instructorCourseAssignment.course',
                'instructorCourseAssignment.program'
            ])
            ->first();

        $students = StudentUserDetials::where('program_id', $timetables->instructorCourseAssignment->program_id)->where("semester", $timetables->instructorCourseAssignment->semester)
            ->whereHas('user', function ($query) {
                $query->where('role', 'student');
            })
            ->with('user')
            ->get();
        return view("Instructor.timetables.attendance", compact("students", "timetableId"));
    }
    public function store(Request $request)
    {
        $request->validate([
            "date" => "required",
        ]);
        // dd($request->all());
        $timetableId = $request->timetableId;
        $date = $request->date;

        foreach ($request->attendance as $userId => $status) {
            StudentAttendance::updateOrCreate(
                [
                    'user_id' => $userId,
                    'timetable_id' => $timetableId,
                    'date' => $date
                ],
                [
                    'attendance' => $status
                ]
            );
        }

        return redirect()->route("instructor.timetables.index")->with('success', 'Attendance saved successfully.');
    }
    public function calculateAttendancePercentage(Request $request)
    {
        $timetableId = $request->query('timetable_id');

        // Get timetable and student list
        $timetable = Timetable::with('instructorCourseAssignment')->findOrFail($timetableId);

        $students = StudentUserDetials::where('program_id', $timetable->instructorCourseAssignment->program_id)
            ->where('semester', $timetable->instructorCourseAssignment->semester)
            ->with('user')
            ->get();

        // Get total number of classes conducted (unique dates for this timetable)
        $totalClasses = StudentAttendance::where('timetable_id', $timetableId)
            ->distinct('date')
            ->count('date');

        // Initialize result array
        $attendanceData = [];

        foreach ($students as $student) {
            // Count present days for each student
            $presentCount = StudentAttendance::where('timetable_id', $timetableId)
                ->where('user_id', $student->user_id)
                ->where('attendance', 'Present') // or use '1' if you're storing attendance as integer
                ->count();

            $percentage = $totalClasses > 0
                ? round(($presentCount / $totalClasses) * 100, 2)
                : 0;

            $attendanceData[] = [
                'student' => $student,
                'present_days' => $presentCount,
                'total_classes' => $totalClasses,
                'percentage' => $percentage,
            ];
        }

        return view('Instructor.timetables.attendanceReport', compact('attendanceData', 'timetableId'));
    }
    public function studentAttendanceReport()
    {


        return view('Student.dashboard.attendanceReport', compact('attendanceData'));
    }
    public function attendanceReport(Request $request)
    {
        $user = auth()->user(); // Get the logged-in user

        // Get the student's details
        $student = StudentUserDetials::where('user_id', $user->id)->firstOrFail();
        $timetableWithResults = StudentResult::where('user_id', $user->id)->pluck('timetable_id');

        // Find timetables matching student's program and semester
        $timetables = Timetable::whereHas('instructorCourseAssignment', function ($query) use ($student) {
            $query->where('program_id', $student->program_id)
                ->where('semester', $student->semester);
        })
            ->with([
                'instructorCourseAssignment.instructor.user',
                'instructorCourseAssignment.course',
                'instructorCourseAssignment.program'
            ])
            ->whereNotIn('id', $timetableWithResults)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        $results = null;

        if ($request->has('timetable_id')) {
            $results = StudentAttendance::with('user')
                ->where('timetable_id', $request->timetable_id)
                ->orderBy('date', 'asc')
                ->get();
        }

        return view('student.attendance.attendance', compact('timetables', 'results'));
    }



}