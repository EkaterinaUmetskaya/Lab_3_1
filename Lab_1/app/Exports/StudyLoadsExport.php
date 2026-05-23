<?php

namespace App\Exports;

use App\Models\StudyLoad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudyLoadsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return StudyLoad::with('teacher')
            ->orderByDesc('id')
            ->get()
            ->map(function ($item) {
                return [
                    'ID' => $item->id,
                    'Преподаватель' => $item->teacher->name ?? '',
                    'Семестр' => $item->semester,
                    'Тип финансирования' => $item->funding_type,
                    'Дисциплина' => $item->discipline_name,
                    'Курс' => $item->course,
                    'Количество студентов' => $item->students_count,
                    'Код специальности' => $item->specialty_code,
                    'Количество групп' => $item->groups_count,
                    'Форма обучения' => $item->education_form,
                    'Всего часов' => $item->total_hours,
                    'Создано' => optional($item->created_at)->format('Y-m-d H:i:s'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Преподаватель',
            'Семестр',
            'Тип финансирования',
            'Дисциплина',
            'Курс',
            'Количество студентов',
            'Код специальности',
            'Количество групп',
            'Форма обучения',
            'Всего часов',
            'Создано',
        ];
    }
}