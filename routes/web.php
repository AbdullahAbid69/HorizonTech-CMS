<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\LectureNoteController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\StudentAttendanceController;
use App\Http\Controllers\StudentResultController;
use App\Http\Controllers\StudyMaterialController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InstructorCourseAssignmentController;
use App\Http\Controllers\AlumniEventController;
use App\Http\Controllers\TimetableController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Route::get('/test', function () {
//     return view('home');
// });
Route::get("/", function () {
    return view("index");
})->name("indexPage");

Route::get("/SignIn", function () {
    return view("authPages.login");
})->name("loginPage");
Route::get("/test", [TimetableController::class, "studentsPromotes"]);

Route::get("/signUp", [UserController::class, "register"])->name("register.page");
Route::post("/student/save", [UserController::class, "userSave"])->name("student.save");
Route::post("/signUp", [UserController::class, "userBasic"])->name("student.basic");
Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logoutUser'])->name('logout.user');

Route::get('/faculty/timetables', [TimetableController::class, 'facultyIndex'])->name('timetables.index');
// Assignment Routes
Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');

// Lecture Notes Routes
Route::get('/lecture-notes/create', [LectureNoteController::class, 'create'])->name('lecturenotes.create');
Route::post('/lecture-notes', [LectureNoteController::class, 'store'])->name('lecturenotes.store');

// Study Materials Routes
Route::get('/study-materials/create', [StudyMaterialController::class, 'create'])->name('studymaterials.create');
Route::post('/study-materials', [StudyMaterialController::class, 'store'])->name('studymaterials.store');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes
Route::middleware('auth')->group(callback: function () {
    Route::get("/password", [UserController::class, "passwordPage"])->name("password.page");
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('password.change');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get("/profile", function () {
            return view("Admin.profile.profile");
        })->name("profile");
        Route::post("/profile", [UserController::class, "updateProfile"])->name("profile.update");
        //Route::middleware('role:admin')->group(function () {
        // Course Routes
        Route::get('/courses', function () {
            return view(view: 'Admin.courses.courses');
        })->name('courses.index');

        Route::get('/courses/add', function () {
            return view('Admin.courses.addCourses');
        })->name('courses.add');

        Route::get('/courses/edit/{id}', function ($id) {
            return view('Admin.courses.editCourses', ['id' => $id]);
        })->name('courses.edit');

        // Program routes
        Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
        Route::get('/programs/add', [ProgramController::class, 'create'])->name('programs.create');
        Route::post('/programs', [ProgramController::class, 'store'])->name('programs.store');
        Route::get('/programs/edit/{id}', [ProgramController::class, 'edit'])->name('programs.edit');
        Route::post('/programs/update/{id}', [ProgramController::class, 'update'])->name('programs.update');
        Route::get('/programs/delete/{id}', [ProgramController::class, 'destroy'])->name('programs.destroy');

        // Soft delete features
        Route::get('/programs/trashed', [ProgramController::class, 'trashed'])->name('programs.trashed');
        Route::get('/programs/restore/{id}', [ProgramController::class, 'restore'])->name('programs.restore');
        Route::get('/programs/force-delete/{id}', [ProgramController::class, 'forceDelete'])->name('programs.forceDelete');

        // Course Routes
        Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
        Route::get('/courses/add', [CourseController::class, 'create'])->name('courses.add');
        Route::post('/courses/add', [CourseController::class, 'store'])->name('courses.store');

        Route::get('/courses/edit/{id}', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/update/{id}', [CourseController::class, 'update'])->name('courses.update');

        Route::delete('/courses/delete/{id}', [CourseController::class, 'destroy'])->name('courses.delete');
        Route::get('/courses/restore/{id}', [CourseController::class, 'restore'])->name('courses.restore'); // Optional: restore soft-deleted
        Route::get('/courses/trashed', [CourseController::class, 'trashed'])->name('courses.trashed'); // Optional: view soft-deleted

        // Instructors Routes
        Route::get('/instructor', [InstructorController::class, 'index'])->name('instructors.index');
        Route::get('/add/instructor', [InstructorController::class, 'create'])->name('instructors.create');
        Route::post('/add/instructor', [InstructorController::class, 'store'])->name('instructors.store');
        Route::delete('/instructor/delete/{id}', [InstructorController::class, 'destroy'])->name('instructors.delete');
        Route::get('instructors/{instructor}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');
        Route::put('instructors/{instructor}', [InstructorController::class, 'update'])->name('instructors.update');


        // Soft delete management
        Route::get('/trashed', [InstructorController::class, 'trashed'])->name('instructors.trashed');
        Route::post('/restore/{id}', [InstructorController::class, 'restore'])->name('instructors.restore');
        Route::delete('/force-delete/{id}', [InstructorController::class, 'forceDelete'])->name('instructors.forceDelete');

        // Faculty Assignment Routes
        Route::get('faculty-assignments', [InstructorCourseAssignmentController::class, 'index'])->name('faculty-assignments.index');
        Route::get('/faculty-assignments/add', [InstructorCourseAssignmentController::class, 'create'])->name('faculty-assignments.create');
        Route::post('/faculty-assignments/add', [InstructorCourseAssignmentController::class, 'store'])->name('faculty-assignments.store');
        Route::delete('/faculty-assignments/{id}', [InstructorCourseAssignmentController::class, 'destroy'])->name('faculty-assignments.delete');
        Route::get('faculty-assignments/{id}/edit', [InstructorCourseAssignmentController::class, 'edit'])->name('faculty-assignments.edit');
        Route::put('faculty-assignments/{id}', [InstructorCourseAssignmentController::class, 'update'])->name('faculty-assignments.update');



        Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
        Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
        Route::post('/departments/create', [DepartmentController::class, 'store'])->name('departments.store');
        Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
        Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

        // alumni-events routes
        Route::get('/alumni-events', [AlumniEventController::class, 'index'])->name('alumni_events.index');
        Route::get('/alumni-events/trashed', [AlumniEventController::class, 'trashed'])->name('alumni_events.trashed');
        Route::get('/alumni-events/create', [AlumniEventController::class, 'create'])->name('alumni_events.create');
        Route::post('/alumni-events', [AlumniEventController::class, 'store'])->name('alumni_events.store');
        Route::get('/alumni-events/{id}/edit', [AlumniEventController::class, 'edit'])->name('alumni_events.edit');
        Route::put('/alumni-events/{id}', [AlumniEventController::class, 'update'])->name('alumni_events.update');
        Route::delete('/alumni-events/{id}', [AlumniEventController::class, 'destroy'])->name('alumni_events.destroy');
        Route::put('/alumni-events/{id}/restore', [AlumniEventController::class, 'restore'])->name('alumni_events.restore');
        Route::delete('/alumni-events/{id}/force-delete', [AlumniEventController::class, 'forceDelete'])->name('alumni_events.forceDelete');

        // Student routes
        Route::get('/application', [UserController::class, 'applications'])->name('application.index');
        Route::get('/application/approve/{id}', [UserController::class, 'applicationsApprove'])->name('applications.approve');
        Route::get('/application/detail', [UserController::class, 'newStudentAdminApplicationDetail'])->name('application.detail');

        // time table routes
        Route::get('/timetables', [TimetableController::class, 'index'])->name('timetables.index');
        Route::get('/timetables/create', [TimetableController::class, 'create'])->name('timetables.create');
        Route::post('/timetables', [TimetableController::class, 'store'])->name('timetables.store');
        Route::post('/timetables/check-conflicts', [TimetableController::class, 'checkConflicts'])->name('timetables.checkConflicts');
        Route::delete('/timetables/{id}', [TimetableController::class, 'destroy'])->name('timetables.destroy');

        Route::get('timetables/{timetable}/edit', [TimetableController::class, 'edit'])->name('timetables.edit');
        Route::put('timetables/{timetable}', [TimetableController::class, 'update'])->name('timetables.update');

        // students route
        Route::get('/students', [UserController::class, 'students'])->name('students.index');
        Route::get('/students/results', [UserController::class, 'showResults'])->name('students.results');
        Route::get('/students/block/{id}', [UserController::class, 'block'])->name('students.block');
        Route::get('/students/unblock/{id}', [UserController::class, 'unblock'])->name('students.unblock');
        Route::delete('/students/destroy/{id}', [UserController::class, 'destroy'])->name('students.destroy');

        Route::get("/student/promote", [UserController::class, "studentsPromotes"])->name("student.promote");
        Route::get("/student/promotes", [UserController::class, "PromoteStudents"])->name("promote.student");


        Route::get("/notice", function () {
            return view("Admin.notices.notices");
        })->name("notice.page");

        Route::get("/notice/compose", [NoticeController::class, "makeNotice"])->name("notice.compose");
        Route::post("/notice/send", [NoticeController::class, "sendNoticeByAdmin"])->name("notice.send");
        // admin.notice.send

        Route::get("/finance", [UserController::class, "financeReport"])->name("finance.report");

        Route::get('/query', [QueryController::class, 'adminIndex'])->name('queries.index');
        Route::get('/query/{id}', [QueryController::class, 'adminShow'])->name('queries.show');
        Route::post('/query/{id}/reply', [QueryController::class, 'reply'])->name('queries.reply');

        Route::get('/instruction', [InstructionController::class, 'indexAdmin'])->name('instructions');
        Route::get('/instruction/create', [InstructionController::class, 'addAdmin'])->name('instructions.create');

        Route::post('/instruction', [InstructionController::class, 'store'])->name('instructions.save');
        Route::delete('/instruction/delete{id}', [InstructionController::class, 'destroy'])->name('instructions.delete');

        //});
    });
    Route::prefix('newStudent')->name('newStudent.')->group(function () {
        Route::middleware('role:newStudent')->group(function () {
            Route::get('/application', [UserController::class, 'newStudentApplications'])->name('application.index');
            Route::get('/application/detail', [UserController::class, 'newStudentApplicationDetail'])->name('application.detail');
            Route::get('/instructor', [InstructorController::class, 'studentIndex'])->name('instructor');
            Route::get('/programs', [ProgramController::class, 'studentIndex'])->name('program');
        });
        Route::get("/profile", function () {
            return view("newStudent.profile.profile");

        })->name("profile");
        Route::get("/instruction", [InstructionController::class, 'newIndex'])->name("instruction");

        Route::post("/profile", [UserController::class, "updateProfile"])->name("profile.update");
        Route::middleware('role:UnRegistered')->group(function () {
            // Route::get('/application', [UserController::class, 'newStudentApplications'])->name('application.index');
            // Route::get('/application/detail', [UserController::class, 'newStudentApplicationDetail'])->name('application.detail');
            Route::get("/application/check", function () {
                return view("newStudent.unregisteredPage");
            })->name("application.page");
            Route::get("/applications", function () {
                return view("newStudent.unregisteredPage");
            })->name("applications.page");

            Route::get("/completeApp", [UserController::class, 'completeApp'])->name("app.comp");
            Route::get("/instruction/page", [InstructionController::class, 'index'])->name("instruction.page");
            Route::get('/instructor/page', [InstructorController::class, 'studentIndex'])->name('instructor.page');
            Route::get('/programs/page', [ProgramController::class, 'studentIndex'])->name('program.page');
            // Route::get("/")

        });
    });
    Route::prefix('student')->name('student.')->group(function () {
        Route::middleware('role:student')->group(function () {
            // here start the user routes    assignment.upload
            Route::get('/timetable', [TimetableController::class, 'studentTimetables'])->name('timetables.index');
            Route::get('/assignment', [AssignmentController::class, 'studentAssignment'])->name('assignment.index');
            Route::get('/assignment/upload', [AssignmentController::class, 'uploadAssignment'])->name('assignment.upload');
            Route::post('/assignment/upload', [AssignmentController::class, 'saveAssignment'])->name('assignment.save');
            Route::get('/studyMaterial', [StudyMaterialController::class, 'studentStudyMaterial'])->name('study.index');
            Route::get('/lectureNotes', [LectureNoteController::class, 'studentLectureNotes'])->name('notes.index');
            Route::get('/result', [StudentResultController::class, "viewStudentResult"])->name("result.index");
            Route::get("/fee", [UserController::class, "studentFee"])->name("student.fee");
            Route::get("/download/pdf", [StudentResultController::class, "downloadStudentResultPDF"])->name("pdf.download");

            Route::get("/profile", function () {
                return view("student.profile.profile");
            })->name("profile");
            ;
            Route::post("/profile", [UserController::class, "updateProfile"])->name("profile.update");

            Route::get('/attendance', [StudentAttendanceController::class, 'attendanceReport'])->name('attendance.report');
        });
    });
    Route::prefix('instructor')->name('instructor.')->group(function () {
        Route::middleware('role:instructor')->group(callback: function () {
            // time table routes
            Route::get('/timetables', [TimetableController::class, 'facultyIndex'])->name('timetables.index');



            //assignment
            Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
            Route::get('/assignment/create/page', [AssignmentController::class, 'createByIns'])->name('assignment.create.page');
            Route::post('/assignments/create', [AssignmentController::class, 'storeAssignment'])->name('assignments.store');
            Route::get('/assignments', [AssignmentController::class, 'facultyIndex'])->name('assignments.index');
            Route::get('/assignments/uploaded', [AssignmentController::class, 'viewAssignmentInstructor'])->name('assignments.uploaded');
            Route::post('/assignments/uploaded', [AssignmentController::class, 'grade'])->name('assignment.grade');



            // study material
            Route::get('/studyMaterial/create', [StudyMaterialController::class, 'createStudy'])->name('study.material.create');
            Route::get('/studyMaterial/create/page', [StudyMaterialController::class, 'createByIns'])->name('study.material.create.page');
            Route::get('/studyMaterial', [StudyMaterialController::class, 'index'])->name('study.material.index');
            Route::post('/studyMaterial/create', [StudyMaterialController::class, 'storeStudyMaterial'])->name('study.material.store');
            // lecture notes
            Route::get('/lectureNotes/create', [LectureNoteController::class, 'create'])->name('lecture.notes.create');
            Route::get('/lectureNote/create', [LectureNoteController::class, 'createByIns'])->name('lectures.notes.create');
            Route::get('/lectureNotes', [LectureNoteController::class, 'index'])->name('lecture.index');
            Route::post('/lectureNotes/create', [LectureNoteController::class, 'store'])->name('lecture.notes.store');

            // lecture notes
            Route::get('/notice/create', [NoticeController::class, 'create'])->name('notice.create');
            // Route::get('/notice', [NoticeController::class, 'index'])->name('notice.index');
            Route::post('/notice/create', [NoticeController::class, 'sendNoticeByInstructor'])->name('notice.store');
            Route::post('/notice/create/student', [NoticeController::class, 'sendNoticeByInstructorToStudent'])->name('notice.send');

            Route::get('/student/list', [UserController::class, 'viewStudent'])->name('user.create');
            Route::get('/student/mail', [UserController::class, 'MailViewToStudent'])->name('send.mail');


            Route::get('/student/attendance', [StudentAttendanceController::class, 'markAttendance'])->name('student.attendance');
            Route::get('/student/report', [StudentAttendanceController::class, 'calculateAttendancePercentage'])->name('student.report');
            Route::post('/student/attendance', [StudentAttendanceController::class, 'store'])->name('attendance.store');

            Route::get('/student/result', [StudentResultController::class, 'uploadResult'])->name('student.result');
            Route::get('/student/result/download', [StudentResultController::class, 'downloadExcelStudentResult'])->name('result.download');
            Route::post('/student/result', [StudentResultController::class, 'storeStudentResults'])->name('results.store');



            Route::get("/results", [StudentResultController::class, "resultsData"])->name("result.student");
            Route::get("/profile", function () {
                return view("instructor.profile.profile");
            })->name("profile");
            Route::post("/profile", [UserController::class, "updateProfile"])->name("profile.update");
        });
    });
    Route::prefix('alunimi')->name('alunimi.')->group(function () {
        Route::middleware('role:alumini')->group(callback: function () {
            Route::get('/events', [AlumniEventController::class, 'AlumniIndex'])->name('event.index');
            Route::get("/profile", function () {
                return view("alumini.profile.profile");
            })->name("profile");
            Route::post("/profile", [UserController::class, "updateProfile"])->name("profile.update");
            Route::get("/results", [StudentResultController::class, "viewAluminiResult"])->name("results");
            Route::get("/query", [QueryController::class, "index"])->name("query");
            Route::get("/query/create", [QueryController::class, "create"])->name("query.create");
            Route::post("/query/store", [QueryController::class, "store"])->name("query.store");

        });
    });
});