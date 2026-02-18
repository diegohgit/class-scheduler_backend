<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentCollection;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return response()->json(['students' => Student::all()]);
        return new StudentCollection(Student::with(['level', 'color'])->get());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        return "hola desde controller";
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
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
