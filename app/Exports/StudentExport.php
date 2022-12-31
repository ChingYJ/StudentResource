<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            '#',
            'name',
            'email',
            'address',
            'course'
        ];
    }

    public function collection()
    {
        return Student::select('id','name','email','address','course')->get();
    }
}
