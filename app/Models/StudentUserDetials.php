<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentUserDetials extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}