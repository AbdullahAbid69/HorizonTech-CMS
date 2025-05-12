<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'sender_id',
        'is_admin',
        'scope',
        'program_id',
        'semester',
        'course_id',
        'student_id',
        'instructor_id',
        'timetable_id',
    ];

    // Available scopes for notices
    public const SCOPES = [
        'all_students',
        'all_faculty',
        'college',
        'program',
        'semester_program',
        'course',
        'student',
        'faculty',
        'timetable',
        'instructor_timetables',
    ];

    // Relationships
    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // public function student()
    // {
    //     return $this->belongsTo(Student::class);
    // }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }
}
