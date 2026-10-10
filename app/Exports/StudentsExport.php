<?php

namespace App\Exports;

use App\Models\Student;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    public function query(): Builder
    {
        return Student::query()
                ->where('is_active', 1)
                ->orderBy('last_name')
                ->orderBy('first_name');
    }

    public function headings(): array
    {
        return ['First Name',
                'Last Name',
                'Email',
                'Phone Number',
                'Birthdate',
                'Age',
                'Level',
                ];
    }

    public function map($student): array
    {
        return [$student->first_name,
                $student->last_name,
                $student->email,
                $student->phone,
                Date::dateTimeToExcel(
                    Carbon::parse($student->birthdate)
                ),
                Carbon::parse($student->birthdate)->age,
                $student->level->name,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            //Turn headers font to bold.
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => 'mm-dd-yyyy',
        ];
    }
}
