<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyLoad extends Model
{
    protected $fillable = [
        'teacher_id',
        'semester',
        'funding_type',
        'discipline_name',
        'course',
        'students_count',
        'specialty_code',
        'groups_count',
        'education_form',
        'lectures_hours',
        'practice_hours',
        'lab_hours',
        'module_control_hours',
        'consultation_semester_hours',
        'consultation_exam_hours',
        'credits_hours',
        'exam_hours',
        'coursework_hours',
        'bachelor_thesis_hours',
        'master_thesis_hours',
        'practice_supervision_hours',
        'gec_hours',
        'vkr_review_hours',
        'vkr_defense_hours',
        'phd_supervision_hours',
        'other_hours',
        'total_hours',
        'note',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}