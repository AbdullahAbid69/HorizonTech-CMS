<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = ['code', 'title', 'description', 'credit_hours', 'prerequisites'];

    protected $casts = [
        'prerequisites' => 'array',
    ];

    protected $dates = ['deleted_at'];

    public function instructorAssignments()
    {
        return $this->hasMany(InstructorCourseAssignment::class);
    }

    public function instructors()
    {
        return $this->belongsToMany(Instructor::class, 'instructor_course_assignments')
                    ->withPivot(['semester', 'program_id'])
                    ->withTimestamps();
    }

    public function prerequisiteCourses()
    {
        return $this->belongsToMany(Course::class, 'course_prerequisite', 'course_id', 'prerequisite_id');
    }

    public function isPrerequisiteFor()
    {
        return $this->belongsToMany(Course::class, 'course_prerequisite', 'prerequisite_id', 'course_id');
    }
}