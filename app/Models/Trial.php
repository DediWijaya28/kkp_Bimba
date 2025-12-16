<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'child_name',
        'parent_name',
        'phone',
        'child_age',
        'status',
        'notes',
        'scheduled_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];
}
