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


    public function markAsSeen(Request $request, $id){

        $request->validate(['student_id' => ['required', 'integer', 'exists:students,id',],
                            'section_id' => ['required', 'integer', 'exists:sections,id',],]);

        try{
            //Check if the student_id from $request is the same
            //as the student_id from url.
            if($id === $request->student_id) $student = Student::find($id);
            else throw new \Exception("Incorrect data.");

            //Attach() doesn't validate whether the student_id-section_id
            //already exists, but if it does it'll trigger an error/
            //because section_student table has a composite PK
            //made of 'student_id'+'section_id'.
            $student->sections()->attach([$request->section_id => ['seen_date' => now()]]);

            $response = "Section marked as seen.";

        }catch(\Illuminate\Database\QueryException $e){
            $response = $e->getCode() === "23000" ? "This section was already marked as seen."
                                                  : "An error has occurred.";
        }

        return response()->json(["message" => $response], );
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
