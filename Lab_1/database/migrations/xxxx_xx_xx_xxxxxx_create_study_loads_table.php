<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_loads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('semester');
            $table->enum('funding_type', ['budget', 'contract']);
            $table->string('discipline_name');
            $table->string('course', 20)->nullable();
            $table->integer('students_count')->nullable();
            $table->string('specialty_code', 50)->nullable();
            $table->decimal('groups_count', 8, 2)->nullable();
            $table->string('education_form', 50)->nullable();
            $table->decimal('lectures_hours', 10, 2)->default(0);
            $table->decimal('practice_hours', 10, 2)->default(0);
            $table->decimal('lab_hours', 10, 2)->default(0);
            $table->decimal('module_control_hours', 10, 2)->default(0);
            $table->decimal('consultation_semester_hours', 10, 2)->default(0);
            $table->decimal('consultation_exam_hours', 10, 2)->default(0);
            $table->decimal('credits_hours', 10, 2)->default(0);
            $table->decimal('exam_hours', 10, 2)->default(0);
            $table->decimal('coursework_hours', 10, 2)->default(0);
            $table->decimal('bachelor_thesis_hours', 10, 2)->default(0);
            $table->decimal('master_thesis_hours', 10, 2)->default(0);
            $table->decimal('practice_supervision_hours', 10, 2)->default(0);
            $table->decimal('gec_hours', 10, 2)->default(0);
            $table->decimal('vkr_review_hours', 10, 2)->default(0);
            $table->decimal('vkr_defense_hours', 10, 2)->default(0);
            $table->decimal('phd_supervision_hours', 10, 2)->default(0);
            $table->decimal('other_hours', 10, 2)->default(0);
            $table->decimal('total_hours', 10, 2)->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_loads');
    }
};