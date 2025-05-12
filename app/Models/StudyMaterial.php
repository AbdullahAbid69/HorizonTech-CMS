<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudyMaterial extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'timetable_id',
    ];

    /**
     * Get the timetable that the study material belongs to.
     */
    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }
}
