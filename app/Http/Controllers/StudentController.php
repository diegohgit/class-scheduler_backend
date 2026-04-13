<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
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
    public function store(StudentRequest $request)
    {
        $validated = $request->validated();
        $student   = Student::create($validated);

        return response()->json($student->id, 201);
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
    public function update(StudentRequest $request, $id)
    {    
        $validated = $request->validated();
        $student = Student::findOrFail($id);
        //Update validated data.
        $student->update($validated);
    
        return response()->json($student->id, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }
}
