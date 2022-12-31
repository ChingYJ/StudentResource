<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;

use Maatwebsite\Excel\Concerns\WithHeadingRow;


class StudentImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use Importable,SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function rules(): array
    {
        return [
            '*.name' => 'required',
            '*.email' => 'required|email|unique:students,email',
            '*.address' => 'required',
            '*.course' => 'required'
        ];
    }

    public function model(array $row)
    {
        $students = new Student([
            'name' => $row['name'],
            'email' => $row['email'],
            'address' => $row['address'],
            'course' => $row['course']
        ]);

        return $students;
    }

    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
    }

}
