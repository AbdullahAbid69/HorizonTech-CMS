<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\StudentAssignmentUpload;
use App\Models\StudentResult;
use App\Models\StudentUserDetials;
use App\Models\Timetable;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentResultController extends Controller
{
    // public function downloadExcelStudentResult(Request $request)
    // {
    //     // dd($request->query('id'));
    //     $timetableId = $request->query('id');
    //     $resultCheck = StudentResult::where("timetable_id", $timetableId)->first();
    //     $data = $resultCheck->with("user")->get();
    //     dd($data);
    // }
    //
    private function calculateGradeAndGPA($totalMarks)
    {
        if ($totalMarks >= 85) {
            return ['grade' => 'A', 'gpa' => 4.0];
        } elseif ($totalMarks >= 75) {
            return ['grade' => 'B+', 'gpa' => 3.5];
        } elseif ($totalMarks >= 65) {
            return ['grade' => 'B', 'gpa' => 3.0];
        } elseif ($totalMarks >= 55) {
            return ['grade' => 'C+', 'gpa' => 2.5];
        } elseif ($totalMarks >= 50) {
            return ['grade' => 'C', 'gpa' => 2.0];
        } elseif ($totalMarks >= 40) {
            return ['grade' => 'D', 'gpa' => 1.0];
        } else {
            return ['grade' => 'F', 'gpa' => 0.0];
        }
    }
    public function resultsData(Request $request)
    {
        $instructorId = Auth::user()->instructor->id;

        $timetables = Timetable::with([
            'instructorCourseAssignment.instructor',
            'instructorCourseAssignment.course',
            'instructorCourseAssignment.program'
        ])
            ->whereHas('instructorCourseAssignment.instructor', function ($query) use ($instructorId) {
                $query->where('instructor_id', $instructorId);
            })
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        $results = [];

        if ($request->has('timetable_id')) {
            $timetableId = $request->timetable_id;

            $results = StudentResult::with('user')
                ->where('timetable_id', $timetableId)
                ->get()
                ->map(function ($result) {
                    $totalMarks = $result->assignmentMarks + $result->sessionalMarks + $result->midMarks + $result->finalMarks;
                    $gradeInfo = $this->calculateGradeAndGPA($totalMarks);

                    $result->totalMarks = $totalMarks;
                    $result->grade = $gradeInfo['grade'];
                    $result->gpa = $gradeInfo['gpa'];

                    return $result;
                });

        }

        return view("Instructor.results.results", compact("timetables", "results"));
    }

    public function uploadResult(Request $request)
    {
        $timetableId = $request->query('timetable_id');
        $resultCheck = StudentResult::where("timetable_id", $timetableId)->first();
        // dd($resultCheck);
        if ($resultCheck) {
            $data = $resultCheck->with("user")->get();
            return view("Instructor.timetables.viewResults", compact("data", "timetableId"));
        }
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
        $assignment = Assignment::where("timetable_id", $timetableId)->get();
        $totalMarks = Assignment::where('timetable_id', $timetableId)->sum('marks');
        $assignmentIds = $assignment->pluck("id")->toArray();
        $weightedAssignmentMarks = [];
        if ($totalMarks > 0) {
            $weightedAssignmentMarks = StudentAssignmentUpload::select('user_id', DB::raw('SUM(marks) as sum_marks'))
                ->whereIn('assignment_id', $assignmentIds)
                ->groupBy('user_id')
                ->get()
                ->mapWithKeys(function ($item) use ($totalMarks) {
                    $weighted = round(($item->sum_marks / $totalMarks) * 15, 2);
                    return [
                        $item->user_id => [
                            'total_obtained' => $item->sum_marks,
                            'weighted' => $weighted
                        ]
                    ];
                });
        }
        return view("Instructor.timetables.results", compact("students", "timetableId", "weightedAssignmentMarks"));
    }
    public function storeStudentResults(Request $request)
    {
        $validated = $request->validate([
            'timetable_id' => 'required|exists:timetables,id',
            'results' => 'required|array',
            'results.*.user_id' => 'required|exists:users,id',
            'results.*.assignmentMarks' => 'required|numeric|min:0|max:15', // 15% weight
            'results.*.sessionalMarks' => 'required|numeric|min:0|max:15',  // 15% weight
            'results.*.midMarks' => 'required|numeric|min:0|max:20',        // 20% weight
            'results.*.finalMarks' => 'required|numeric|min:0|max:50',      // 50% weight
        ]);
        foreach ($validated['results'] as $result) {
            $total = $result['assignmentMarks'] + $result['sessionalMarks'] + $result['midMarks'] + $result['finalMarks'];
            $status = $total >= 50 ? 'Pass' : 'Fail';
            StudentResult::create([
                'timetable_id' => $validated['timetable_id'],
                'user_id' => $result['user_id'],
                'assignmentMarks' => $result['assignmentMarks'],
                'sessionalMarks' => $result['sessionalMarks'],
                'midMarks' => $result['midMarks'],
                'finalMarks' => $result['finalMarks'],
                "status" => $status,
            ]);
        }
        return redirect()->route("instructor.timetables.index")->with('success', 'Results saved successfully.');
    }
    public function viewAluminiResult()
    {
        $user = auth()->user(); // Get the logged-in student user

        $program = Auth::user()->studentsDetails->program->name;
        // dd($semester);

        // Get student details
        $student = StudentUserDetials::where('user_id', $user->id)->firstOrFail();

        // Get timetable IDs for student's program and semester
        $timetableIds = Timetable::whereHas('instructorCourseAssignment', function ($query) use ($student) {
            $query->where('program_id', $student->program_id);
        })->pluck('id');

        // Fetch results of the logged-in student for these timetables
        $results = StudentResult::where('user_id', $user->id)
            ->whereIn('timetable_id', $timetableIds)
            ->with([
                'timetable.instructorCourseAssignment.course',
                'timetable.instructorCourseAssignment.instructor.user'
            ])
            ->get();

        return view('alumini.results.results', compact('results', "program"));
    }
    public function viewStudentResult()
    {
        $user = auth()->user();

        $program = $user->studentsDetails->program->name;
        $semester = $user->studentsDetails->semester;

        $student = StudentUserDetials::where('user_id', $user->id)->firstOrFail();

        $timetableIds = Timetable::whereHas('instructorCourseAssignment', function ($query) use ($student) {
            $query->where('program_id', $student->program_id)
                ->where('semester', $student->semester);
        })->pluck('id');

        $results = StudentResult::where('user_id', $user->id)
            ->whereIn('timetable_id', $timetableIds)
            ->with([
                'timetable.instructorCourseAssignment.course',
                'timetable.instructorCourseAssignment.instructor.user'
            ])
            ->get()
            ->map(function ($result) {
                $totalMarks = $result->assignmentMarks + $result->sessionalMarks + $result->midMarks + $result->finalMarks;
                $gradeInfo = $this->calculateGradeAndGPA($totalMarks);

                $result->totalMarks = $totalMarks;
                $result->grade = $gradeInfo['grade'];
                $result->gpa = $gradeInfo['gpa'];

                return $result;
            });

        return view('student.result.result', compact('results', 'program', 'semester'));
    }

    public function downloadStudentResultPDF()
    {
        $user = auth()->user();
        $student = StudentUserDetials::where('user_id', $user->id)->firstOrFail();

        $timetableIds = Timetable::whereHas('instructorCourseAssignment', function ($query) use ($student) {
            $query->where('program_id', $student->program_id)
                ->where('semester', $student->semester);
        })->pluck('id');

        $results = StudentResult::where('user_id', $user->id)
            ->whereIn('timetable_id', $timetableIds)
            ->with([
                'timetable.instructorCourseAssignment.course',
                'timetable.instructorCourseAssignment.instructor.user'
            ])
            ->get();
        // view("student.result.resultTemplate")
        $pdf = Pdf::loadView('student.result.resultTemplate', compact('results'));
        return $pdf->download('student-results.pdf');
    }

}