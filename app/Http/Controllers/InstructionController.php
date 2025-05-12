<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructionController extends Controller
{
    //
    public function index()
    {
        $instructions = Instruction::all();
        return view("newStudent.instruction.instruction", compact("instructions"));
    }
    public function indexAdmin()
    {
        $instructions = Instruction::all();
        return view("Admin.instruction.instrction", compact("instructions"));
    }
    public function addAdmin()
    {
        return view("Admin.instruction.addInstruction");
    }

    public function newIndex()
    {
        $instructions = Instruction::all();
        return view("newStudent.instruction.instruction", compact("instructions"));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'instruction' => 'required|string|max:255',
        ]);

        $instruction = Instruction::create($validated);

        return redirect()->route("admin.instructions")->with("success", "Instruction added Successfully");
    }
    public function destroy($id)
    {
        try {
            $instruction = Instruction::findOrFail($id);
            $instruction->delete();

            return redirect()->route('admin.instructions')
                ->with('success', 'Instruction deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting instruction: ' . $e->getMessage());
        }
    }
}