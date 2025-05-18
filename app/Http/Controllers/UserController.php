<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Program;
use App\Models\StudentProgram;
use App\Models\StudentProgramFee;
use App\Models\StudentQualification;
use App\Models\StudentResult;
use App\Models\StudentUserDetials;
use App\Models\Timetable;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    //
    public function register()
    {
        $programs = Program::all();
        return view("authPages.signUP", compact("programs"));
    }
    public function viewStudent(Request $request)
    {
        $timetableId = $request->query('timetable_id');

        $timetables = Timetable::whereHas('instructorCourseAssignment')
            ->where('id', $timetableId) // Add this line to filter by timetable id
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
        // dd($studentsInSameProgram);
        return view('Instructor.timetables.viewStudent', compact('students'));
    }
    public function MailViewToStudent(Request $request)
    {
        $id = $request->query("id");
        return view("Instructor.timetables.mailStudent", compact("id"));

    }
    public function userBasic(Request $request)
    {
        // dd("e");
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // 'fatherName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string', // Assuming mobile is required
            'status' => 'required|string',              // Assuming status is required
            'role' => 'required|string',                // Assuming role is required
            'password' => 'required|string|min:6|confirmed',
            'photoOfStudent' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Handle file upload
            if ($request->hasFile('photoOfStudent')) {
                $image = $request->file('photoOfStudent');

                // Create a unique name for the file
                $imageName = time() . '_' . $image->getClientOriginalName();

                // Move it to the public/profiles directory
                $image->move(public_path('profiles'), $imageName);

                // Save path relative to public folder
                $profileImagePath = 'profiles/' . $imageName;
            } else {
                $profileImagePath = null;
            }

            // Create user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'password' => $validatedData['password'], // Always hash passwords!
                'status' => $validatedData['status'],
                'profile_image' => $profileImagePath,
                'role' => $validatedData['role'],
            ]);
            $message = "Dear {$user->name},\n\n" .
                "Your account has been created successfully.\n" .
                "You can now log in using the following credentials:\n\n" .
                "Email: {$user->email}\n" .
                "Please log in and complete your application.\n\n" .
                "Regards,\nHorizonTech Team";

            // Send email
            Mail::to($user->email)->send(new SendMail($message, 'Welcome to Our Horizon Tech'));
            // dd($user);

            return redirect()->route('loginPage')->with('success', 'Registration successful! Please login.');   

        } catch (\Exception $e) {
            return redirect()->back()
                // ->withInput()
                ->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }
    public function completeApp()
    {
        $programs = Program::all();
        return view("newStudent.completeApp", compact("programs"));
    }

    public function userSave(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'program' => 'required|exists:programs,id',
                'mobileNumber' => 'required|string|max:20',
                'cnic' => 'required|string|max:20',
                'religion' => 'required|string|max:100',
                'nationality' => 'required|string|max:100',
                'dateOfBirth' => 'required|date',
                'gender' => 'required|in:male,female,other',
                'maritalStatus' => 'required|in:true,false',
                'homeAddress' => 'required|string|max:255',
                'CNICPdf' => 'required|file|mimes:pdf|max:2048',

                'fatherOccupation' => 'required|string|max:255',
                'fatherName' => 'required|string|max:255',
                'designation' => 'nullable|string|max:255',
                'NameOfOrg' => 'nullable|string|max:255',
                'officeAddress' => 'nullable|string|max:255',
                'fatherOfficePhone' => 'nullable|string|max:20',
                'AnyOtherContactNumber' => 'nullable|string|max:20',
                'AnnualIncome' => 'nullable|string|max:100',
                'fatherReligion' => 'nullable|string|max:100',
                'fatherNationality' => 'nullable|string|max:100',
                'fatherCnic' => 'nullable|string|max:20',

                'qualifications' => 'required|array|min:1',
                'qualifications.*.degreeType' => 'required|string|in:metric,intermediate,diplomaInNursing,postBasicDiploma,other',
                'qualifications.*.Majors' => 'required|string|max:255',
                'qualifications.*.institute' => 'required|string|max:255',
                'qualifications.*.country' => 'required|string|max:100',
                'qualifications.*.duration' => 'required|string|max:100',
                'qualifications.*.result' => 'required|string|max:100',
                'qualifications.*.file' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            ]);

            // Handle file uploads before the transaction
            $cnicPdfPath = null;
            if ($request->hasFile('CNICPdf')) {
                $cnicPdfName = time() . '_cnic.' . $request->CNICPdf->extension();
                $request->CNICPdf->move(public_path('uploads/cnic'), $cnicPdfName);
                $cnicPdfPath = 'uploads/cnic/' . $cnicPdfName;
            }

            // Handle qualification file uploads
            $qualificationFiles = [];
            if (isset($validatedData['qualifications'])) {
                foreach ($request->file('qualifications') as $index => $qualification) {
                    if (isset($qualification['file'])) {
                        $file = $qualification['file'];
                        $fileName = time() . '_qualification_' . $index . '.' . $file->extension();
                        $file->move(public_path('uploads/qualifications'), $fileName);
                        $qualificationFiles[$index] = 'uploads/qualifications/' . $fileName;
                    }
                }
            }

            DB::transaction(function () use ($validatedData, $cnicPdfPath, $qualificationFiles) {
                // Create student details
                $studentDetails = StudentUserDetials::create([
                    'user_id' => Auth::user()->id,
                    'program_id' => $validatedData['program'],
                    'nationality' => $validatedData['nationality'],
                    'dateOfBirth' => $validatedData['dateOfBirth'],
                    'cnic' => $validatedData['cnic'],
                    'cnic_file' => $cnicPdfPath, // Assuming you'll add this field to your migration
                    'religion' => $validatedData['religion'],
                    'homeAddress' => $validatedData['homeAddress'],
                    'mobileNumber' => $validatedData['mobileNumber'],
                    'fatherOccupation' => $validatedData['fatherOccupation'],
                    'fatherName' => $validatedData['fatherName'],
                    'designation' => $validatedData['designation'] ?? null,
                    'NameOfOrg' => $validatedData['NameOfOrg'] ?? null,
                    'officeAddress' => $validatedData['officeAddress'] ?? null,
                    'fatherOfficePhone' => $validatedData['fatherOfficePhone'] ?? null,
                    'AnyOtherContactNumber' => $validatedData['AnyOtherContactNumber'] ?? null,
                    'AnnualIncome' => $validatedData['AnnualIncome'] ?? null,
                    'fatherReligion' => $validatedData['fatherReligion'] ?? null,
                    'fatherNationality' => $validatedData['fatherNationality'] ?? null,
                    'fatherCnic' => $validatedData['fatherCnic'] ?? null,
                    'gender' => $validatedData['gender'],
                    'maritalStatus' => $validatedData['maritalStatus'] === 'true',
                ]);

                // Save student qualifications
                foreach ($validatedData['qualifications'] as $index => $qualification) {
                    StudentQualification::create([
                        'user_id' => Auth::user()->id,
                        'degreeType' => $qualification['degreeType'],
                        'Majors' => $qualification['Majors'],
                        'institute' => $qualification['institute'],
                        'country' => $qualification['country'],
                        'duration' => $qualification['duration'],
                        'result' => $qualification['result'],
                        'qualification_file' => $qualificationFiles[$index] ?? null, // Assuming you'll add this field to your migration
                    ]);
                }
            });
            User::where("id", Auth::user()->id)->update([
                "role" => "newStudent",
            ]);
            return redirect()->route("home")->with('success', 'Student information saved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }
    public function applications()
    {
        $applications = User::where("role", "newStudent")->with(["studentsDetails.program", "studentQualifications"])->get();
        // dd($applications);
        return view("Admin.applications.applications", compact("applications"));
    }
    public function applicationsApprove($id)
    {
        try {
            $user = User::find($id);
            if ($user) {
                $user->role = "student";
                $user->save();
                if ($user->studentUserDetials) {
                    $programId = $user->studentUserDetials->program_id;
                    $user->studentUserDetials->semester = 1;
                    $user->studentUserDetials->save();
                    $program = Program::find($programId);
                    $fee = $program->fee_per_semester;
                    StudentProgramFee::create([
                        "user_id" => $id,
                        "program_id" => $programId,
                        "semester" => 1,
                        "amount" => $fee,
                    ]);
                }
                return redirect()->route('admin.application.index')->with('success', 'Application Accepted Successfully');
            } else {
                return redirect()->back()->with(
                    'error',
                    "User Not Found"
                );
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function newStudentApplications()
    {
        // dd($id);
        try {
            $applications = User::where("role", "newStudent")->with(["studentsDetails.program", "studentQualifications"])->where("id", Auth::user()->id)->get();
            return view("newStudent.applications.applications", compact("applications"));

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function newStudentApplicationDetail(Request $request)
    {
        // dd($id);
        try {
            $id = $request->id;
            $application = User::where("role", "newStudent")->with(["studentsDetails.program", "studentQualifications"])->where("id", $id)->first();
            return view("newStudent.applications.applicationDetails", compact("application"));

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function newStudentAdminApplicationDetail(Request $request)
    {
        try {
            $id = $request->id;
            $application = User::where("role", "newStudent")->with(["studentsDetails.program", "studentQualifications"])->where("id", $id)->first();
            // dd($application);
            return view("Admin.applications.detailedApplication", compact("application"));

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function students()
    {
        $students = User::where('role', 'student')
            ->with([
                'studentUserDetials.program',
                'studentQualifications'
            ])
            ->get();

        return view('admin.students.students', compact('students'));
    }
    public function showResults(Request $request)
    {
        $student = StudentUserDetials::with("user")->where('user_id', $request->id)->firstOrFail();

        // Get timetable IDs for student's program and semester
        $timetableIds = Timetable::whereHas('instructorCourseAssignment', function ($query) use ($student) {
            $query->where('program_id', $student->program_id)
                ->where('semester', $student->semester);
        })->pluck('id');

        // Fetch results of the logged-in student for these timetables
        $results = StudentResult::where('user_id', $request->id)
            ->whereIn('timetable_id', $timetableIds)
            ->with([
                'timetable.instructorCourseAssignment.course',
                'timetable.instructorCourseAssignment.instructor.user'
            ])
            ->get();
        // dd($resultCheck);
        return view("Admin.results.results", compact("results", "student"));

    }

    public function block($id)
    {
        $student = User::findOrFail($id);
        $student->status = 'Inactive'; // string value
        $student->save();

        return redirect()->route('admin.students.index')->with('success', 'Student blocked successfully.');
    }


    public function unblock($id)
    {
        $student = User::findOrFail($id);
        $student->status = 'active';
        $student->save();

        return redirect()->route('admin.students.index')->with('success', 'Student unblocked successfully.');
    }
    public function studentsPromotes()
    {
        $students = User::with('studentsDetails')
            ->where('role', 'student')
            ->get();
        // dd($students);

        $promotableStudents = [];

        foreach ($students as $student) {
            $details = $student->studentsDetails;

            if (!$details) {
                continue; // Skip if no student details found
            }
            // Get all timetable IDs for the student's current semester & program
            $timetableIds = Timetable::whereHas('instructorCourseAssignment', function ($query) use ($details) {
                $query->where('program_id', $details->program_id)
                    ->where('semester', $details->semester);
            })
                ->pluck('id');

            $results = StudentResult::where('user_id', $student->id)
                ->whereIn('timetable_id', $timetableIds)
                ->get();

            $totalCourses = $timetableIds->count();
            $passedCourses = $results->where('status', 'Pass')->count();
            // dd($passedCourses);
            if ($totalCourses > 0 && $results->count() == $totalCourses && $passedCourses == $totalCourses) {
                $promotableStudents[] = $student;
            }
        }
        return view('admin.promotes.promotes', compact('promotableStudents'));
    }

    public function PromoteStudents(Request $request)
    {
        $id = $request->query("id");
        $user = User::with("studentsDetails")->find($id);
        $program = Program::find($user->studentsDetails->program_id);
        if ($program->duration_in_semesters === $user->studentsDetails->semester) {
            $user->role = "alumini";
            $user->save();
        } else {
            if ($user) {
                if ($user->studentUserDetials) {
                    $programId = $user->studentUserDetials->program_id;
                    $user->studentUserDetials->semester = ($user->studentUserDetials->semester + 1);
                    $user->studentUserDetials->save();
                    $program = Program::find($programId);
                    $fee = $program->fee_per_semester;
                    StudentProgramFee::create([
                        "user_id" => $id,
                        "program_id" => $programId,
                        "semester" => 2,
                        "amount" => $fee,
                    ]);
                }
            }
        }


        return redirect()->route("admin.student.promote")->with("success", "Student Promoted Successfully");

    }

    public function destroy($id)
    {
        $student = User::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
    public function studentFee()
    {
        $fees = StudentProgramFee::where("user_id", Auth::user()->id)->get();
        return view("student.fee.fee", compact("fees"));
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate the form input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile image upload if provided
        if ($request->hasFile('profile_image')) {
            // Delete old image if it exists
            if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }

            // Store new image
            $file = $request->file('profile_image');
            $filename = 'profile_' . $user->id . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path('uploads/profile_images'), $filename);

            // Save relative path in DB
            $validated['profile_image'] = 'uploads/profile_images/' . $filename;
        }

        // Update user profile
        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    public function financeReport(Request $request)
    {
        $query = StudentProgramFee::with(["user.studentsDetails", "program"]);

        // Apply date filter if both start and end dates are present
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59',
            ]);
        }

        $fees = $query->get();

        return view("Admin.financeReport.financeReport", compact("fees"));
    }
    public function passwordPage()
    {
        return view("password");
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = auth()->user();
        $user->update(['password' => bcrypt($request->new_password)]);

        return back()->with('success', 'Password changed successfully.');
    }
}