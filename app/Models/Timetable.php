<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timetable extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'instructor_course_assignment_id',
        'day',
        'start_time',
        'end_time',
        'room',
    ];

    public function instructorCourseAssignment()
    {
        return $this->belongsTo(InstructorCourseAssignment::class);
    }

    public function course()
    {
        return $this->instructorCourseAssignment->course;
    }

    public function program()
    {
        return $this->instructorCourseAssignment->program;
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
    public function studentResults()
    {
        return $this->hasMany(StudentResult::class);
    }
    public function attendance()
    {
        return $this->belongsTo(StudentAttendance::class);
    }
}