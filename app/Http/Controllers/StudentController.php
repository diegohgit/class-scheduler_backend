<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //When $request contains 'search'
        //runs a callback function wich runs the search function from model
        //if 'search' is not included, returns the full list of students.
        $students = Student::with(['level', 'color'])
                            ->when( $request->search,
                                    fn($q) => $q->searchByName($request->search))
                            ->get();
        
        return new StudentCollection($students);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Store a new student
        //$student = new Student;
        //$student->name      = $request->name;
        //$student->birthDate = '1999-06-09';
        //$student->phone     = $request->phone;
        //$student->homework  = $request->homework;
        //$student->progress  = $request->progress;
        //$student->color_id  = $request->color;
        //$student->level_id  = $request->level;
        //$student->save();

        print_r($request);
        return ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load(['level', 'color']);
        
        return new StudentResource($student);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
