<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClinicSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'clinic_staff_id',
        'checkup_type_id',
        'session_date',
        'reason',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function clinicStaff()
    {
        return $this->belongsTo(User::class, 'clinic_staff_id');
    }

    public function checkupType()
    {
        return $this->belongsTo(CheckupType::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function vitals()
    {
        return $this->hasOne(Vital::class);
    }
}
