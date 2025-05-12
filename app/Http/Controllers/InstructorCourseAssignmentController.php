<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InstructorCourseAssignment;
use App\Models\Instructor;
use App\Models\Course;
use App\Models\Program;
use Illuminate\Http\Request;

class InstructorCourseAssignmentController extends Controller
{
    public function index()
    {
        $assignments = InstructorCourseAssignment::with(['instructor', 'course', 'program'])->get();
        return view('admin.faculty-assignments.faculty-assignments', compact('assignments'));
    }
    public function create()
    {
        $instructors = Instructor::with('user')->get();
        $courses = Course::all();
        $programs = Program::all();

        return view('admin.faculty-assignments.addFaculty-assignments', compact('instructors', 'courses', 'programs'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'instructor_id' => 'required|exists:instructors,id',
            'course_id' => 'required|exists:courses,id',
            'program_id' => 'required|exists:programs,id',
            'semester' => 'required|integer|min:1',
        ]);

        InstructorCourseAssignment::create($request->all());

        return redirect()->route('admin.faculty-assignments.index')->with('success', 'Assignment created successfully.');
    }

    public function destroy($id)
    {
        $assignment = InstructorCourseAssignment::findOrFail($id);
        $assignment->delete(); // Soft delete

        return redirect()->route('admin.faculty-assignments.index')->with('success', 'Assignment deleted successfully.');
    }

    public function trashed()
    {
        $trashed = InstructorCourseAssignment::onlyTrashed()->with(['instructor', 'course', 'program'])->get();
        return view('admin.faculty-assignments.trashed', compact('trashed'));
    }
    public function edit($id)
    {
        $assignment = InstructorCourseAssignment::findOrFail($id);
        $instructors = Instructor::with('user')->get();
        $courses = Course::all();
        $programs = Program::all();

        return view('Admin.faculty-assignments.editFaculty-assignments', compact('assignment', 'instructors', 'courses', 'programs'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'instructor_id' => 'required|exists:instructors,id',
            'course_id' => 'required|exists:courses,id',
            'program_id' => 'required|exists:programs,id',
            'semester' => 'required|integer|min:1',
        ]);

        $assignment = InstructorCourseAssignment::findOrFail($id);
        $assignment->update($request->all());

        return redirect()->route('admin.faculty-assignments.index')->with('success', 'Assignment updated successfully.');
    }
    public function restore($id)
    {
        $assignment = InstructorCourseAssignment::onlyTrashed()->findOrFail($id);
        $assignment->restore();

        return redirect()->route('admin.faculty-assignments.index')->with('success', 'Assignment restored successfully.');
    }

    public function forceDelete($id)
    {
        $assignment = InstructorCourseAssignment::onlyTrashed()->findOrFail($id);
        $assignment->forceDelete();

        return redirect()->route('admin.faculty-assignments.trashed')->with('success', 'Assignment permanently deleted.');
    }
}