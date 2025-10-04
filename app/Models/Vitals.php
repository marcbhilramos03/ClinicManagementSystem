<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vital extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_session_id',
        'blood_pressure',
        'heart_rate',
        'respiratory_rate',
        'temperature',
        'weight',
        'height',
        'bmi',
    ];

    public function clinicSession()
    {
        return $this->belongsTo(ClinicSession::class);
    }
}

