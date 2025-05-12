<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    // Show all active (non-deleted) programs
    public function index()
    {
        $programs = Program::all(); // This only shows non-soft-deleted by default
        return view('Admin.programs.programs', compact('programs'));
    }
    public function studentIndex()
    {
        $programs = Program::all();
        return view(view: 'newStudent.programs.programData', data: compact("programs"));
    }
    // Show trashed (soft-deleted) programs
    public function trashed()
    {
        $programs = Program::onlyTrashed()->get();
        return view('Admin.programs.trashedPrograms', compact('programs'));
    }

    // Show form to create a new program
    public function create()
    {
        return view('Admin.programs.addPrograms');
    }

    // Store a new program
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:programs,code',
            'description' => 'nullable|string',
            'duration_in_semesters' => 'required|integer|min:1',
            'fee_per_semester' => 'required|integer|min:1',
        ]);

        Program::create($request->all());

        return redirect()->route('admin.programs.index')->with('success', 'Program created successfully!');
    }

    // Show form to edit an existing program
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('Admin.programs.editPrograms', compact('program'));
    }

    // Update an existing program
    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:programs,code,' . $program->id,
            'description' => 'nullable|string',
            'duration_in_semesters' => 'required|integer|min:1',
        ]);

        $program->update($request->all());

        return redirect()->route('admin.programs.index')->with('success', 'Program updated successfully!');
    }

    // Soft delete
    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program soft-deleted successfully!');
    }

    // Restore a soft-deleted program
    public function restore($id)
    {
        $program = Program::onlyTrashed()->findOrFail($id);
        $program->restore();

        return redirect()->route('admin.programs.index')->with('success', 'Program restored successfully!');
    }

    // Permanently delete (force delete)
    public function forceDelete($id)
    {
        $program = Program::onlyTrashed()->findOrFail($id);
        $program->forceDelete();

        return redirect()->route('admin.programs.trashed')->with('success', 'Program permanently deleted!');
    }
}