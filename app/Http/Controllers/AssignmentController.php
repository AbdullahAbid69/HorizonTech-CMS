<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\StudentAssignmentUpload;
use App\Models\StudentResult;
use App\Models\StudentUserDetials;
use App\Models\StudyMaterial;
use App\Models\Timetable;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Instructor;

class AssignmentController extends Controller
{
    /**
     * Show the form to create a new assignment for a specific timetable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        // Get the timetable ID from query parameters
        $timetableId = $request->query('timetable_id');


        // Fetch the timetable along with its related data (e.g., course, program)
        $timetable = Timetable::with([
            'instructorCourseAssignment.course',
            'instructorCourseAssignment.program'
        ])->findOrFail($timetableId);

        // Return the view with timetable data
        return view('instructor.timetables.addAssignments', compact('timetable'));
    }
    public function createByIns()
    {

        $ins = Instructor::where("user_id", Auth::user()->id)->first();
        // dd(vars: $id)
        $id = $ins->id;
        $timetables = Timetable::with([
            'instructorCourseAssignment.course',
            'instructorCourseAssignment.program'
        ])
            ->whereHas('instructorCourseAssignment', function ($query) use ($id) {
                $query->where('instructor_id', $id);
            })
            ->get();
        // dd($timetables);
        return view("Instructor.assignments.addAssignment", compact("timetables"));
    }

    /**
     * Store a new assignment in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAssignment(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'marks' => 'required|numeric',
            'timetable_id' => 'required|exists:timetables,id',
            'assignment_file' => 'required|file|mimes:pdf|max:2048', // only allow PDF up to 2MB
        ]);

        $filePath = null;

        if ($request->hasFile('assignment_file')) {
            $file = $request->file('assignment_file');
            $filename = time() . '_' . $file->getClientOriginalName(); // unique filename
            $filePath = 'assignments/' . $filename;


            // Move file to public/assignments
            $file->move(public_path('assignments'), $filename);
        }
        // dd($filePath);


        Assignment::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'marks' => $validatedData['marks'],
            'timetable_id' => $validatedData['timetable_id'],
            'file_path' => $filePath,
        ]);

        return redirect()->back()
            ->with('success', 'Assignment created successfully.');
    }

    public function facultyIndex()
    {
        $instructorId = Auth::id();
        $instructor = Instructor::where('user_id', Auth::id())->first();
        if ($instructor) {
            $timetableIds = Timetable::whereHas('instructorCourseAssignment', function ($query) use ($instructor) {
                $query->where('instructor_id', $instructor->id);
            })->pluck('id');
        } else {
            // No instructor record found for this user
            $timetableIds = collect(); // empty collection
        }

        // Fetch assignments with eager loading if needed
        $assignments = Assignment::whereIn('timetable_id', $timetableIds)
            ->latest()
            ->get();
        //dd($timetableIds );
        return view('Instructor.assignments.assignments', compact('assignments'));
    }

    public function studentAssignment()
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
            ->pluck('id');
        // ->get();
// dd($timetables);
        $assignments = Assignment::whereIn('timetable_id', $timetables)
            ->with('timetable.instructorCourseAssignment.course')
            ->whereNotIn('timetable_id', $timetableWithResults)
            ->latest()
            ->get();
        // dd($assignments);

        return view('student.assignment.assignment', compact('assignments'));
    }
    public function uploadAssignment(Request $request)
    {
        $id = $request->id;
        $assignment = Assignment::find($id);
        // dd($assignment);
        return view("student.assignment.assignmentUpload", compact("assignment"));
    }
    public function saveAssignment(Request $request)
    {
        $validated = $request->validate([
            'assignmentId' => 'required|exists:assignments,id',
            'file' => 'required|file|mimes:pdf|max:5120', // PDF only, max 5MB
        ]);
        $assignment = Assignment::find($validated['assignmentId']);
        $user = Auth::user();
        $filePath = null;
        try {
            if (Carbon::now()->gt(Carbon::parse($assignment->due_date))) {
                return redirect()->route("student.assignment.index")->with("error", "Assignment due date has already passed. You cannot
upload now.");

            }
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName(); // unique filename
                $filePath = 'studentAssignment/' . $filename;

                // Move file to public/studentAssignment
                $file->move(public_path('studentAssignment'), $filename);
            } else {
                return back()->withErrors(['file' => 'File upload failed.']);
            }

            // Check if record already exists
            $existingUpload = StudentAssignmentUpload::where('user_id', $user->id)
                ->where('assignment_id', $validated['assignmentId'])
                ->first();

            if ($existingUpload) {
                // Delete old file if needed (optional)
                if ($existingUpload->file_path && file_exists(public_path($existingUpload->file_path))) {
                    unlink(public_path($existingUpload->file_path));
                }

                // Update existing record
                $existingUpload->update([
                    'file_path' => $filePath,
                ]);
            } else {
                // Create new record
                StudentAssignmentUpload::create([
                    'user_id' => $user->id,
                    'assignment_id' => $validated['assignmentId'],
                    'marks' => null,
                    'remarks' => null,
                    'file_path' => $filePath,
                ]);
            }
            return redirect()->route("student.assignment.index")->with("success", "Assignment Saved Successfully");
        } catch (Exception $e) {
            return redirect()->route("student.assignment.index")->with("error", $e->getMessage());
        }

    }
    public function viewAssignmentInstructor(Request $request)
    {
        $assignmentId = $request->id; // assignment_id
        $students = User::where("role", "student")->get();

        // Get all uploads for this assignment
        $uploads = StudentAssignmentUpload::where("assignment_id", $assignmentId)->get()->keyBy('user_id');
        // dd($submittedIds);
        return view("Instructor.assignments.markAssignment", compact("students", "uploads", "assignmentId"));

    }
    public function grade(Request $request)
    {
        $assignmentId = $request->assignment_id;
        $data = $request->input('data', []);

        foreach ($data as $userId => $entry) {
            $upload = StudentAssignmentUpload::where('assignment_id', $assignmentId)
                ->where('user_id', $userId)
                ->first();

            if ($upload) {
                $upload->update([
                    'marks' => $entry['marks'],
                    'remarks' => $entry['remarks'],
                ]);
            } else {
                StudentAssignmentUpload::create([
                    'user_id' => $userId,
                    'assignment_id' => $assignmentId,
                    'marks' => 0,
                    'remarks' => "Assignment Not Uploaded",
                    'file_path' => null,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Marks and remarks saved successfully.');
    }


}