<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all(); // You can add ->whereNull('deleted_at') if soft deletes are used
        return view('admin.departments.departments', compact('departments'));
    }

    public function create()
    {
        return view('Admin.departments.addDepartments');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Department::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.departments.index')->with('success', 'Department added successfully!');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('Admin.departments.editDepartments', compact('department'));
    }

    public function update(Request $request, Department $department)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $department->update([
        'name' => $request->name,
        'description' => $request->description,
    ]);

    return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully!');
}

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete(); // Soft delete

        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully!');
    }
}