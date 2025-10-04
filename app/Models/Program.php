<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

   protected $fillable = ['name', 'department_id']; // adjust as needed

    public $timestamps = false;

    public function personalInformations()
    {
        return $this->hasMany(PersonalInformation::class);
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
