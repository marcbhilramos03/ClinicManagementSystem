<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $table = 'personal_information';

    protected $fillable = [
        'user_id',
        'department_id',
        'school_id',
        'category',
        'program_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'birthdate',
        'address',
        'contact_no',
        'emergency_contact_name',
        'emergency_contact_no',
        'emergency_contact_relationship',
    ];
    public $timestamps = false; // <-- Add this line

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function credential()
    {
        return $this->hasOne(Credential::class);
    }
}
