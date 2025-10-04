<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'role',
        'profile_skipped',
        'profile_complete',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // -----------------------------
    // Role Helpers
    // -----------------------------
    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    public function isStaff(): bool
    {
        return $this->role === 'clinic_staff';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // -----------------------------
    // Relationships
    // -----------------------------

    // Personal information (profile)
    public function personalInformation()
    {
        return $this->hasOne(PersonalInformation::class);
    }

    // Medical records CREATED FOR this user (when patient)
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id');
    }

    // Medical records CREATED BY this user (when staff)
    public function createdMedicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'staff_id');
    }

    // Appointments (as a patient)
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }
    public function clinicSessionsAsPatient()
    {
        return $this->hasMany(ClinicSession::class, 'patient_id');
    }

    public function clinicSessionsAsStaff()
    {
        return $this->hasMany(ClinicSession::class, 'clinic_staff_id');
    }

    public function inventoriesAdded()
    {
        return $this->hasMany(Inventory::class, 'admin_id');
    }

}
