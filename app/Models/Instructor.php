<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Authenticatable
{
    use SoftDeletes;

    protected $guarded = [

    ];
    // protected $hidden = ['password'];

    // protected $dates = ['deleted_at'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function courseAssignments()
    {
        return $this->hasMany(InstructorCourseAssignment::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'instructor_course_assignments')
            ->withPivot(['semester', 'program_id'])
            ->withTimestamps();
    }
}