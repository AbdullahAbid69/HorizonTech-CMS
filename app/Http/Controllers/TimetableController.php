<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\StudentResult;
use App\Models\StudentUserDetials;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Timetable;
use App\Models\InstructorCourseAssignment;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'instructor_course_assignment_id' => 'required|exists:instructor_course_assignments,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string',
        ]);

        $assignment = InstructorCourseAssignment::findOrFail($validated['instructor_course_assignment_id']);

        $conflicts = $this->detectConflicts(
            $assignment->instructor_id,
            $assignment->program_id,
            $assignment->semester,
            $validated['day'],
            $validated['start_time'],
            $validated['end_time'],
            $validated['room']
        );

        if (!empty($conflicts)) {
            return response()->json([
                'status' => 'error',
                'errors' => $conflicts,
            ], 422);
        }

        $timetable = Timetable::create($validated);

        return redirect()->route('admin.timetables.index') // 👈 your correct route here
            ->with('success', 'Timetable slot created successfully.');
    }

    public function checkConflicts(Request $request)
    {
        //dd($request->all());

        $validated = $request->validate([
            'instructor_id' => 'required|exists:instructors,id',
            'program_id' => 'required|exists:programs,id',
            'semester' => 'required|integer',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable',
        ]);

        $conflicts = $this->detectConflicts(
            $validated['instructor_id'],
            $validated['program_id'],
            $validated['semester'],
            $validated['day'],
            $validated['start_time'],
            $validated['end_time'],
            $validated['room']
        );

        if (!empty($conflicts)) {
            return response()->json([
                'status' => 'conflict',
                'errors' => $conflicts,
            ], 422);
        }

        return response()->json(['status' => 'ok']);
    }
    public function edit(Timetable $timetable)
    {
        $assignments = InstructorCourseAssignment::with(['instructor.user', 'course', 'program'])
            ->get();

        return view('admin.timetables.edittimetables', compact('timetable', 'assignments'));
    }

    public function update(Request $request, Timetable $timetable)
    {
        $validated = $request->validate([
            'instructor_course_assignment_id' => 'required|exists:instructor_course_assignments,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $assignment = InstructorCourseAssignment::findOrFail($validated['instructor_course_assignment_id']);

        $conflicts = $this->detectConflicts(
            $assignment->instructor_id,
            $assignment->program_id,
            $assignment->semester,
            $validated['day'],
            $validated['start_time'],
            $validated['end_time'],
            $validated['room'],
            $timetable->id // Pass the current timetable ID to exclude it from conflict checks
        );

        if (!empty($conflicts)) {
            return back()->withErrors($conflicts)->withInput();
        }

        $timetable->update($validated);

        return redirect()->route('admin.timetables.index')
            ->with('success', 'Timetable slot updated successfully.');
    }

    // Update your detectConflicts method to accept the timetable ID parameter
    // private function detectConflicts($instructorId, $programId, $semester, $day, $startTime, $endTime, $room, $excludeTimetableId = null)
    // {
    //     $conflicts = [];

    //     // Check for instructor availability
    //     $instructorConflict = Timetable::where('instructor_course_assignments.instructor_id', $instructorId)
    //         ->join('instructor_course_assignments', 'instructor_course_assignments.id', '=', 'timetables.instructor_course_assignment_id')
    //         ->where('timetables.day', $day)
    //         ->where(function ($query) use ($startTime, $endTime) {
    //             $query->where(function ($q) use ($startTime, $endTime) {
    //                 $q->where('timetables.start_time', '<', $endTime)
    //                     ->where('timetables.end_time', '>', $startTime);
    //             });
    //         });

    //     if ($excludeTimetableId) {
    //         $instructorConflict->where('timetables.id', '!=', $excludeTimetableId);
    //     }

    //     if ($instructorConflict->exists()) {
    //         $conflicts['instructor'] = 'Instructor is already assigned to another class during this time.';
    //     }

    //     // Check for room availability
    //     $roomConflict = Timetable::where('room', $room)
    //         ->where('day', $day)
    //         ->where(function ($query) use ($startTime, $endTime) {
    //             $query->where(function ($q) use ($startTime, $endTime) {
    //                 $q->where('start_time', '<', $endTime)
    //                     ->where('end_time', '>', $startTime);
    //             });
    //         });

    //     if ($excludeTimetableId) {
    //         $roomConflict->where('id', '!=', $excludeTimetableId);
    //     }

    //     if ($roomConflict->exists()) {
    //         $conflicts['room'] = 'Room is already booked during this time.';
    //     }

    //     // Check for program/semester conflicts (same program/semester shouldn't have overlapping classes)
    //     $programConflict = Timetable::where('instructor_course_assignments.program_id', $programId)
    //         ->where('instructor_course_assignments.semester', $semester)
    //         ->join('instructor_course_assignments', 'instructor_course_assignments.id', '=', 'timetables.instructor_course_assignment_id')
    //         ->where('timetables.day', $day)
    //         ->where(function ($query) use ($startTime, $endTime) {
    //             $query->where(function ($q) use ($startTime, $endTime) {
    //                 $q->where('timetables.start_time', '<', $endTime)
    //                     ->where('timetables.end_time', '>', $startTime);
    //             });
    //         });

    //     if ($excludeTimetableId) {
    //         $programConflict->where('timetables.id', '!=', $excludeTimetableId);
    //     }

    //     if ($programConflict->exists()) {
    //         $conflicts['program'] = 'There is already a class scheduled for this program and semester during this time.';
    //     }

    //     return $conflicts;
    // }

    public function index()
    {
        $timetables = Timetable::with([
            'instructorCourseAssignment' => function ($query) {
                $query->withTrashed()->with([
                    'instructor' => function ($query) {
                        $query->withTrashed()->with([
                            'user'
                        ]);
                    },
                    'course' => function ($query) {
                        $query->withTrashed();
                    },
                    'program' => function ($query) {
                        $query->withTrashed();
                    }
                ]);
            }
        ])
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        return view('Admin.timetables.timetables', compact('timetables'));
    }

    public function facultyIndex()
    {
        $instructorId = Auth::user()->instructor->id;
        // dd($instructorId);
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
        // dd($timetables);
        return view('instructor.timetables.timetables', compact('timetables'));
    }

    public function destroy($id)
    {
        $timetable = Timetable::findOrFail($id);
        $timetable->delete();

        // return response()->redirect()->route("admin.timetables.index")->with("success", "Timetable deleted successfully");
        return redirect()->route('admin.timetables.index')
            ->with('success', 'Timetable deleted successfully');
    }
    public function create()
    {
        $assignments = InstructorCourseAssignment::with([
            'instructor.user',
            'course',
            'program'
        ])->get();

        return view('admin.timetables.addTimetables', compact('assignments'));
    }

    /**
     * Conflict detection logic for instructor, room, and program/semester.
     */
    private function detectConflicts($instructorId, $programId, $semester, $day, $start, $end, $room = null)
    {
        $errors = [];

        // Instructor conflict
        $instructorConflict = Timetable::where('day', $day)
            ->whereHas('instructorCourseAssignment', function ($q) use ($instructorId) {
                $q->where('instructor_id', $instructorId);
            })
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_time', '<=', $start)
                            ->where('end_time', '>=', $end);
                    });
            })
            ->exists();

        if ($instructorConflict) {
            $errors['instructor'] = 'Instructor is already teaching at this time.';
        }

        // Room conflict
        if ($room) {
            $roomConflict = Timetable::where('day', $day)
                ->where('room', $room)
                ->where(function ($q) use ($start, $end) {
                    $q->whereBetween('start_time', [$start, $end])
                        ->orWhereBetween('end_time', [$start, $end])
                        ->orWhere(function ($q2) use ($start, $end) {
                            $q2->where('start_time', '<=', $start)
                                ->where('end_time', '>=', $end);
                        });
                })
                ->exists();

            if ($roomConflict) {
                $errors['room'] = 'Room is already booked at this time.';
            }
        }

        // Program + semester conflict
        $programConflict = Timetable::where('day', $day)
            ->whereHas('instructorCourseAssignment', function ($q) use ($programId, $semester) {
                $q->where('program_id', $programId)
                    ->where('semester', $semester);
            })
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->where('start_time', '<=', $start)
                            ->where('end_time', '>=', $end);
                    });
            })
            ->exists();

        if ($programConflict) {
            $errors['program_semester'] = 'A class already exists for this program and semester at this time.';
        }

        return $errors;
    }
    public function studentTimetables()
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
            ->whereNotIn('id', $timetableWithResults)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
        // dd($timetables);
        return view('student.timetable.timetable', compact('timetables'));
    }



}