<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of courses (excluding soft-deleted ones).
     */
    public function index()
    {
        $courses = Course::all();
        return view('Admin.courses.courses', compact('courses'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $courses = Course::whereNull('deleted_at')->get(); // Fetch existing courses to show as possible prerequisites
        return view('admin.courses.addCourses', compact('courses'));
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:courses,code',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'credit_hours' => 'required|integer|min:1|max:6',
            'prerequisites' => 'nullable|array',
        ]);

        Course::create([
            'code' => $request->code,
            'title' => $request->title,
            'description' => $request->description,
            'credit_hours' => $request->credit_hours,
            'prerequisites' => $request->prerequisites,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Show the form for editing a course.
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $allCourses = Course::where('id', '!=', $id)->get(); // exclude self
        return view('Admin.courses.editCourses', compact('course', 'allCourses'));
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'code' => 'required|string|unique:courses,code,' . $course->id,
            'title' => 'required|string',
            'description' => 'nullable|string',
            'credit_hours' => 'required|integer|min:1|max:6',
            'prerequisites' => 'nullable|array',
        ]);

        $course->update([
            'code' => $request->code,
            'title' => $request->title,
            'description' => $request->description,
            'credit_hours' => $request->credit_hours,
            'prerequisites' => $request->prerequisites,
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Soft delete a course.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }

    /**
     * Show list of soft-deleted courses.
     */
    public function trashed()
    {
        $courses = Course::onlyTrashed()->get();
        return view('Admin.courses.trashed', compact('courses'));
    }

    /**
     * Restore a soft-deleted course.
     */
    public function restore($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();

        return redirect()->route('admin.courses.index')->with('success', 'Course restored successfully.');
    }

    /**
     * Permanently delete a soft-deleted course.
     */
    public function forceDelete($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->forceDelete();

        return redirect()->route('admin.courses.trashed')->with('success', 'Course permanently deleted.');
    }
}
