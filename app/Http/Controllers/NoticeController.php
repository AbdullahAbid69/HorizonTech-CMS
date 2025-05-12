<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Instructor;
use App\Models\Notice;
use App\Models\StudentUserDetials;
use App\Models\Timetable;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NoticeController extends Controller
{
    public function create(Request $request)
    {
        $timetableId = $request->query('timetable_id');
        return view('Instructor.timetables.addNotice', compact('timetableId'));
    }
    public function sendNoticeByInstructor(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'timetable_id' => 'required|exists:timetables,id',
        ]);
        try {
            $timetables = Timetable::whereHas('instructorCourseAssignment')
                ->where('id', $request->timetable_id)
                ->with([
                    'instructorCourseAssignment.instructor.user',
                    'instructorCourseAssignment.course',
                    'instructorCourseAssignment.program'
                ])
                ->first();

            $students = StudentUserDetials::where('program_id', $timetables->instructorCourseAssignment->program_id)->where("semester", $timetables->instructorCourseAssignment->semester)
                ->whereHas('user', function ($query) {
                    $query->where('role', 'student');
                })
                ->with('user')
                ->get();
            foreach ($students as $student) {
                $user = $student->user;
                Mail::to($user->email)->send(new SendMail($request->message, $request->subject));
            }
            return redirect()->route("instructor.timetables.index")->with("success", "Mail Sent Successfully");

        } catch (Exception $e) {
            return redirect()->route("instructor.timetables.index")->with("error", $e->getMessage());
        }
    }
    public function sendNoticeByInstructorToStudent(Request $request)
    {
        // dd("e");
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'id' => 'required',
        ]);
        $user = User::where("id", $request->id)->first();

        Mail::to($user->email)->send(new SendMail($request->message, $request->subject));
        return redirect()->route("instructor.timetables.index")->with("success", "Mail Sent Successfully");
    }




    public function store(Request $request)
    {
        // dd($request->all());
        $id = Auth::user()->id;
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'timetable_id' => 'required|exists:timetables,id',
        ]);
        Notice::create([
            "sender_id" => $id,
            "is_admin" => false,
            "scope" => "instructor_timetables",
            "timetable_id" => $request->timetable_id,
            "title" => $request->title,
            "content" => $request->content,
        ]);
        return redirect()->route('instructor.notice.create', ['timetable_id' => $validatedData['timetable_id']])
            ->with('success', 'Lecture Note added successfully.');
    }
    public function makeNotice(Request $request)
    {
        $scope = $request->query("scope");
        return view("Admin.notices.noticeToAll", compact("scope"));
    }
    public function sendNoticeByAdmin(Request $request)
    {
        $request->validate([
            "scope" => "required",
            "subject" => "required",
            "message" => "required",
        ]);
        try {
            if ($request->scope === "all") {
                $users = User::where("role", "!=", "admin")->where("role", "!=", "newStudent")->get();
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new SendMail($request->message, $request->subject));
                }
                return redirect()->route("admin.notice.page")->with("success", "Mail Sent Successfully");
            } elseif ($request->scope === "students") {
                $users = User::where("role", "student")->get();
                // dd($users);
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new SendMail($request->message, $request->subject));
                }
                return redirect()->route("admin.notice.page")->with("success", "Mail Sent Successfully");
            } elseif ($request->scope === "newStudents") {
                $users = User::where("role", "newStudent")->get();
                // dd($users);
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new SendMail($request->message, $request->subject));
                }
                return redirect()->route("admin.notice.page")->with("success", "Mail Sent Successfully");
            } elseif ($request->scope === "instructors") {
                $users = User::where("role", "instructor")->get();
                // dd($users);
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new SendMail($request->message, $request->subject));
                }
                return redirect()->route("admin.notice.page")->with("success", "Mail Sent Successfully");
            } elseif ($request->scope === "alumini") {
                $users = User::where("role", "alumini")->get();
                // dd($users);
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new SendMail($request->message, $request->subject));
                }
                return redirect()->route("admin.notice.page")->with("success", "Mail Sent Successfully");
            } elseif ($request->scope === "alumini") {
                $users = User::where("role", "alumini")->get();
                // dd($users);
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new SendMail($request->message, $request->subject));
                }
                return redirect()->route("admin.notice.page")->with("success", "Mail Sent Successfully");
            } elseif ($request->scope === "allAudience") {
                $users = User::where("role", "!=", "admin")->get();
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new SendMail($request->message, $request->subject));
                }
                return redirect()->route("admin.notice.page")->with("success", "Mail Sent Successfully");
            }
        } catch (Exception $e) {
            return redirect()->route("admin.notice.page")->with("error", $e->getMessage());
        }
    }
}