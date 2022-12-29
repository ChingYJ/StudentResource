<?php

namespace App\Http\Controllers;

use App\Http\Resources\Student as ResourcesStudent;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

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
        return response()->json(['students' => $studentsResource,'results'=>[
            "students" => count($students),
            "per_page" => $perPage
        ]]);
    }

    public function Search(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        error_log($name);
        $students = new Student;
        if (!empty($name)) {
            $students = Student::where('name', 'like', '%' . $name . '%')->get();
        }

        if (!empty($email)) {
            $students = Student::Where('email', 'like', '%' . $email . '%')->get();
        }

        if(!empty($name) && !empty($email)){
            $students = Student::where('name', 'like', '%' . $name . '%')->Where('email', 'like', '%' . $email . '%')->get();
        }

        if (count($students) != 0) {
            $studentsResource = ResourcesStudent::collection($students);
            return response()->json(['students' => $studentsResource]);
        }else{
            return response()->json(['msg'=>'Nothings Found']);
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
}
