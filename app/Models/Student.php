<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'nickname',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'address',
        'postal_code',
        'status',
        'start_date',
        'province_id',
        'city_id',
        'district_id',
        'village_id',
        'street_address',
        'rt',
        'rw',
        'house_number',
        'nim',
        'revision_note',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'start_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->hasOne(StudentParent::class);
    }

    // Warranty relationship removed

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function classSelections()
    {
        return $this->hasMany(ClassSelection::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }
}
