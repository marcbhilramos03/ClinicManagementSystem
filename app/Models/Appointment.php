<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'clinic_staff_id',
        'department_id',
        'program_id',
        // 'patient_id', // important
        'appointment_date',
        'status',
        'notes',
    ];
    protected $casts = [
    'appointment_date' => 'datetime',
    ];


    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function clinicStaff()
    {
        return $this->belongsTo(User::class, 'clinic_staff_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}



