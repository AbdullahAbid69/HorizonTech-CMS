<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\LectureNote;
use App\Models\StudentResult;
use App\Models\StudentUserDetials;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LectureNoteController extends Controller
{
    /**
     * Show the form to create a new lecture note for a specific timetable.
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
        return view('Instructor.timetables.addLectureNotes', compact('timetable'));
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
        return view("Instructor.lectureNotes.addLectureNote", compact("timetables"));
    }

    /**
     * Store a new lecture note in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lecture_file' => 'required|file|mimes:pdf,docx,pptx|max:10240',  // Ensure it's a file with valid extensions
            'timetable_id' => 'required|exists:timetables,id',
        ]);

        // Store the file and get the file path
        $filePath = null;
        if ($request->hasFile('lecture_file')) {
            $file = $request->file('lecture_file');
            $filename = time() . '_' . $file->getClientOriginalName(); // or any unique naming
            $filePath = 'lecture/' . $filename;
            $file->move(public_path('lecture'), $filename);
        }

        // Create a new lecture note linked to the timetable
        LectureNote::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'file_path' => $filePath,
            'timetable_id' => $validatedData['timetable_id'],
        ]);

        // Redirect back with a success message
        return redirect()
        ->back()
            ->with('success', 'Lecture Note added successfully.');
    }
    public function index()
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
        $assignments = LectureNote::whereIn('timetable_id', $timetableIds)
            ->latest()
            ->get();
        //dd($timetableIds );
        return view('Instructor.lectureNotes.lecture', compact('assignments'));
    }
    public function studentLectureNotes()
    {
        $user = auth()->user(); // Get the logged-in user
        $timetableWithResults = StudentResult::where('user_id', $user->id)->pluck('timetable_id');
        // Get the student's details
        $student = StudentUserDetials::where('user_id', $user->id)->firstOrFail();

        // Find timetables matching student's program and semester
        $timetables = Timetable::whereHas('instructorCourseAssignment', function ($query) use ($student) {
            $query->where('program_id', $student->program_id)
                ->where('semester', $student->semester);
        })

            ->with([
                'instructorCourseAssignment.instructor.user',
                'instructorCourseAssignment.course',
                'instructorCourseAssignment.program'
            ])->pluck('id');
        $notes = LectureNote::whereIn('timetable_id', $timetables)
            ->with('timetable.instructorCourseAssignment.course')
            ->whereNotIn('timetable_id', $timetableWithResults)
            ->latest()
            ->get();
        // dd($assignments);

        return view('student.lectureNotes.lectureNotes', compact('notes'));
    }
}