<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinic_session_id',
        'diagnosis',
        'treatment',
        'notes',
    ];

    public function clinicSession()
    {
        return $this->belongsTo(ClinicSession::class);
    }
    public function patient()
    {
        // Access patient through clinic session
        return $this->hasOneThrough(
            User::class,            // final model
            ClinicSession::class,   // intermediate model
            'id',                   // ClinicSession primary key
            'id',                   // User primary key
            'clinic_session_id',    // MedicalRecord foreign key
            'patient_id'            // ClinicSession foreign key to patient
        );
    }

    public function staff()
    {
        // Access staff through clinic session
        return $this->hasOneThrough(
            User::class,
            ClinicSession::class,
            'id',
            'id',
            'clinic_session_id',
            'clinic_staff_id'
        );
    }
}

