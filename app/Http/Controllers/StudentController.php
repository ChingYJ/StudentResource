<?php

namespace App\Http\Controllers;

use App\Exports\StudentExport;
use App\Http\Resources\Student as ResourcesStudent;
use App\Imports\StudentImport;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use DB;
use PHPUnit\Framework\MockObject\Builder\Stub;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $students = new Student;
        $students = Student::paginate($perPage);
        $studentsResource = ResourcesStudent::collection($students);
        return response()->json(['students' => $studentsResource, 'results' => [
            "students" => count($students),
            "per_page" => $perPage
        ]]);
    }

    public function Search(Request $request)
    {
        $search = $request->input('search');
        $students = new Student;
        if (!empty($search)) {
                $students = Student::where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->get();
        }else{
            $students = Student::all();
        }

        if (count($students) != 0) {
            $studentsResource = ResourcesStudent::collection($students);
            return response()->json(['students' => $studentsResource]);
        } else {
            return response()->json(['msg' => 'Nothings Found']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $students = new Student;
        $students = Student::where('id', $id)->get();
        $studentsResource = ResourcesStudent::collection($students);
        return response()->json(['students' => $studentsResource]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function importFile(Request $request)
    {
        $validateData = $request->validate([
            'file' => 'required|mimes:xlsx, csv, xls'
        ]);

        $import = new StudentImport;
        $import->import($request->file('file'));
        error_log($import->errors());

        return response()->json([
            'message' => 'Students imported successfully',
        ]);
    }

    public function exportFile(Request $request)
    {
        return Excel::download(new StudentExport, 'Student.xlsx');
    }
}
