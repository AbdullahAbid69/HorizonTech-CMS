<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\StudentResult;
use App\Models\StudentUserDetials;
use App\Models\StudyMaterial;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudyMaterialController extends Controller
{
    /**
     * Show the form to create a new study material for a specific timetable.
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
        return view('study_materials.create', compact('timetable'));
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
        return view("Instructor.studyMaterial.addStudyMaterial", compact("timetables"));
    }
    public function createStudy(Request $request)
    {

        // Get the timetable ID from query parameters
        $timetableId = $request->query('timetable_id');

        // Fetch the timetable along with its related data (e.g., course, program)
        $timetable = Timetable::with([
            'instructorCourseAssignment.course',
            'instructorCourseAssignment.program'
        ])->findOrFail($timetableId);

        // Return the view with timetable data
        return view('Instructor.timetables.addStudyMaterial', compact('timetable'));
    }
    public function Index()
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
        $assignments = StudyMaterial::whereIn('timetable_id', $timetableIds)
            ->latest()
            ->get();
        //dd($timetableIds );
        return view('Instructor.studyMaterial.study', compact('assignments'));
    }
    /**
     * Store a new study material in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeStudyMaterial(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',

            'timetable_id' => 'required|exists:timetables,id',
            'study_file' => 'required|file|mimes:pdf|max:2048', // only allow PDF up to 2MB
        ]);

        $filePath = null;
        if ($request->hasFile('study_file')) {
            $file = $request->file('study_file');
            $filename = time() . '_' . $file->getClientOriginalName(); // or any unique naming
            $filePath = 'study/' . $filename;
            $file->move(public_path('study'), $filename);
        }
        // dd($filePath);

        StudyMaterial::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'timetable_id' => $validatedData['timetable_id'],
            'file_path' => $filePath,
        ]);

        return redirect()->back()
            ->with('success', 'Study created successfully.');
    }
    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,docx,pptx|max:10240',  // Ensure it's a valid file type
            'timetable_id' => 'required|exists:timetables,id',
        ]);

        // Store the file and get the file path
        $filePath = $request->file('file')->store('study_materials');

        // Create a new study material linked to the timetable
        StudyMaterial::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'file_path' => $filePath,
            'timetable_id' => $validatedData['timetable_id'],
        ]);

        // Redirect back with a success message
        return redirect()->route('study_materials.create', ['timetable_id' => $validatedData['timetable_id']])
            ->with('success', 'Study Material added successfully.');
    }
    public function studentStudyMaterial()
    {
        $user = auth()->user(); // Get the logged-in user

        // Get the student's details
        $timetableWithResults = StudentResult::where('user_id', $user->id)->pluck('timetable_id');
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
        // dd($timetables);
        $studyMaterials = StudyMaterial::whereIn('timetable_id', $timetables)
            ->with('timetable.instructorCourseAssignment.course')
            ->whereNotIn('timetable_id', $timetableWithResults)
            ->latest()
            ->get();
        // dd($assignments);

        return view('student.studyMaterial.studyMaterial', compact('studyMaterials'));
    }
}