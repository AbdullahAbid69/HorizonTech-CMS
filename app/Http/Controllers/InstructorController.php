<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Instructor;

use App\Models\Department;

use App\Models\User;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    // Show all instructors (excluding soft deleted by default)
    public function index()
    {
        $instructors = Instructor::with(["user", "department"])->get();
        return view('admin.instructors.instructors', compact('instructors'));
    }
    public function studentIndex()
    {
        $instructors = Instructor::with(["user", "department"])->get();
        return view('newStudent.instructor.instructor', compact('instructors'));
    }
    public function create()
    {

        $departments = Department::all();
        return view('admin.instructors.addInstructors', compact('departments'));

    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|confirmed|min:6',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|string|max:255',
            'final_qualification' => 'required|string|max:255',
        ]);
        // dd($validated);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
            'status' => 'active', // Or 'Inactive', depending on your logic
            "role" => "instructor",
        ]);

        // Create instructor linked to user
        Instructor::create([
            'user_id' => $user->id,
            'department_id' => $validated['department_id'],
            'designation' => $validated['designation'],
            'final_qualification' => $validated['final_qualification'],
        ]);

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor created successfully.');
    }
    public function edit(Instructor $instructor)
    {
        $departments = Department::all();
        $instructor->load('user'); // Load the related user model
        return view('Admin.instructors.editInstructors', compact('instructor', 'departments'));
    }
    public function update(Request $request, Instructor $instructor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $instructor->user_id,
            'phone' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|string|max:255',
            'final_qualification' => 'required|string|max:255',
        ]);

        // Update user
        $user = $instructor->user;
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->save();

        // Update instructor
        $instructor->update([
            'department_id' => $validated['department_id'],
            'designation' => $validated['designation'],
            'final_qualification' => $validated['final_qualification'],
        ]);

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor updated successfully.');
    }
    // Soft delete an instructor
    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->delete();

        return redirect()->back()->with('success', 'Instructor deleted successfully.');
    }

    // Show soft-deleted instructors (trashed)
    public function trashed()
    {
        $instructors = Instructor::onlyTrashed()->get();
        return view('admin.instructors.trashed', compact('instructors'));
    }

    // Restore a soft-deleted instructor
    public function restore($id)
    {
        $instructor = Instructor::onlyTrashed()->findOrFail($id);
        $instructor->restore();

        return redirect()->back()->with('success', 'Instructor restored successfully.');
    }

    // Permanently delete instructor
    public function forceDelete($id)
    {
        $instructor = Instructor::onlyTrashed()->findOrFail($id);
        $instructor->forceDelete();

        return redirect()->back()->with('success', 'Instructor permanently deleted.');
    }
}