<?php

namespace App\Imports;

use App\Models\Teacher;
use App\Models\StudyLoad;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class StudyLoadImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $teacher = Teacher::firstOrCreate(
            ['full_name' => 'Гукай Алексей Евгеньевич'],
            [
                'department' => 'Кафедра компьютерных технологий',
                'position' => 'преподаватель',
                'academic_year' => '2025/2026',
            ]
        );

        $semester = null;
        $fundingType = null;

        foreach ($rows as $row) {
            $line = implode(' ', array_map(fn($v) => trim((string)$v), $row->toArray()));
            $first = trim((string)($row[0] ?? ''));
            $discipline = trim((string)($row[1] ?? ''));

            if (str_contains($line, 'I') && str_contains(mb_strtolower($line), 'бюдж')) {
                $semester = 1;
                $fundingType = 'budget';
                continue;
            }

            if (str_contains($line, 'I') && str_contains(mb_strtolower($line), 'контракт')) {
                $semester = 1;
                $fundingType = 'contract';
                continue;
            }

            if (str_contains($line, 'II') && str_contains(mb_strtolower($line), 'бюдж')) {
                $semester = 2;
                $fundingType = 'budget';
                continue;
            }

            if (str_contains($line, 'II') && str_contains(mb_strtolower($line), 'контракт')) {
                $semester = 2;
                $fundingType = 'contract';
                continue;
            }

            if (!$semester || !$fundingType) continue;
            if (!is_numeric($first)) continue;
            if ($discipline === '' || str_contains(mb_strtoupper($discipline), 'ИТОГО')) continue;

            StudyLoad::create([
                'teacher_id' => $teacher->id,
                'semester' => $semester,
                'funding_type' => $fundingType,
                'discipline_name' => $discipline,
                'course' => $row[2] ?? null,
                'students_count' => is_numeric($row[3] ?? null) ? (int)$row[3] : null,
                'specialty_code' => $row[4] ?? null,
                'groups_count' => is_numeric($row[5] ?? null) ? $row[5] : null,
                'education_form' => $row[6] ?? null,
                'lectures_hours' => (float)($row[7] ?? 0),
                'practice_hours' => (float)($row[8] ?? 0),
                'lab_hours' => (float)($row[9] ?? 0),
                'module_control_hours' => (float)($row[10] ?? 0),
                'consultation_semester_hours' => (float)($row[11] ?? 0),
                'consultation_exam_hours' => (float)($row[12] ?? 0),
                'credits_hours' => (float)($row[13] ?? 0),
                'exam_hours' => (float)($row[14] ?? 0),
                'coursework_hours' => (float)($row[15] ?? 0),
                'bachelor_thesis_hours' => (float)($row[16] ?? 0),
                'master_thesis_hours' => (float)($row[17] ?? 0),
                'practice_supervision_hours' => (float)($row[18] ?? 0),
                'gec_hours' => (float)($row[19] ?? 0),
                'vkr_review_hours' => (float)($row[20] ?? 0),
                'vkr_defense_hours' => (float)($row[21] ?? 0),
                'phd_supervision_hours' => (float)($row[22] ?? 0),
                'other_hours' => (float)($row[23] ?? 0),
                'total_hours' => (float)($row[24] ?? 0),
                'note' => $row[25] ?? null,
            ]);
        }
    }
}