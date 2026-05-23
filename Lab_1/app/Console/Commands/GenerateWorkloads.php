<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Teacher;
use App\Models\StudyLoad;

class GenerateStudyLoadData extends Command
{
    protected $signature = 'studyload:generate {count=10}';
    protected $description = 'Generate test study load data';

    public function handle()
    {
        $count = (int) $this->argument('count');

        $teacher = Teacher::firstOrCreate(
            ['full_name' => 'Гукай Алексей Евгеньевич'],
            [
                'department' => 'Кафедра компьютерных технологий',
                'position' => 'преподаватель',
                'academic_year' => '2025/2026'
            ]
        );

        $disciplines = [
            'Web-программирование',
            'Программирование мобильных устройств',
            'ООП',
            'Базы данных',
            'Информационные системы',
        ];

        for ($i = 0; $i < $count; $i++) {
            StudyLoad::create([
                'teacher_id' => $teacher->id,
                'semester' => rand(1, 2),
                'funding_type' => rand(0, 1) ? 'budget' : 'contract',
                'discipline_name' => $disciplines[array_rand($disciplines)],
                'course' => rand(1, 4),
                'students_count' => rand(1, 60),
                'specialty_code' => '09.03.01',
                'groups_count' => rand(1, 20) / 10,
                'education_form' => 'очная',
                'lectures_hours' => rand(0, 32),
                'practice_hours' => rand(0, 32),
                'lab_hours' => rand(0, 160),
                'total_hours' => rand(20, 250),
            ]);
        }

        $this->info("Добавлено {$count} записей");
        return Command::SUCCESS;
    }
}