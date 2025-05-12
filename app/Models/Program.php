<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'code', 'description', 'duration_in_semesters', "fee_per_semester"];

    protected $dates = ['deleted_at'];
    public function instructorAssignments()
    {
        return $this->hasMany(InstructorCourseAssignment::class);
    }
}