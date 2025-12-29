<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'student_id',
        'amount',
        'payment_method',
        'proof_path',
        'status',
        'verified_at',
        'registration_number',
        'registration_fee',
        'spp_fee',
        'authorized_signer',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
