<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstructorCourseAssignment extends Model
{
    use SoftDeletes;
    

    protected $fillable = ['instructor_id', 'course_id', 'semester','program_id'];


    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
