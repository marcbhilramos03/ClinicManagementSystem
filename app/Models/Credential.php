<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    use HasFactory;

    protected $fillable = [
        'personal_information_id',
        'credential_type',
        'license_type',
        'degree',
    ];    
    public $timestamps = false; // <-- Add this line


    public function personalInformation()
    {
        return $this->belongsTo(PersonalInformation::class);
    }
}
