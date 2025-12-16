<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    protected $table = 'parents';

    protected $fillable = [
        'student_id',
        'father_name',
        'mother_name',
        'father_occupation',
        'father_phone',
        'mother_occupation',
        'phone',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
