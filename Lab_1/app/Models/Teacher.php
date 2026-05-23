<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'full_name',
        'department',
        'position',
        'academic_year',
    ];

    public function studyLoads()
    {
        return $this->hasMany(StudyLoad::class);
    }
}