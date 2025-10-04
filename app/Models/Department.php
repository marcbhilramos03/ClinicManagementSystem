<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
        
    public $timestamps = false;


    public function personalInformations()
    {
        return $this->hasMany(PersonalInformation::class);
    }
    
    public function programs()
    {
        return $this->hasMany(Program::class);
    }
    public function profile()
{
    $user = auth()->user();
    $departments = Department::all();

    return view('patient.profile', compact('user', 'departments'));
}
}
