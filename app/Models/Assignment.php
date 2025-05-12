<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory;
    use SoftDeletes;
    // protected $fillable = [
    //     'title',
    //     'description',
    //     'due_date',
    //     'timetable_id',
    // ];
    protected $guarded = [];
    /**
     * Get the timetable that the assignment belongs to.
     */
    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }
    public function AssignmentStudent()
    {
        return $this->hasOne(StudentAssignmentUpload::class, "assignment_id");
    }
}