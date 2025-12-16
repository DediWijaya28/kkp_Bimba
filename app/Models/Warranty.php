<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    protected $fillable = [
        'student_id',
        'signed_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
