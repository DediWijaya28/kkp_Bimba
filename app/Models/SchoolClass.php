<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'name',
        'program',
        'day',
        'time',
        'quota',
        'filled',
        'price',
    ];

    public function selections()
    {
        return $this->hasMany(ClassSelection::class, 'class_id');
    }
}
