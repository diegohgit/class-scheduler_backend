<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentIndexResource;
use App\Http\Resources\StudentShowResource;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['level', 'color'])
                            ->where('is_active', 1)
                            ->get();

        return response()->json(StudentIndexResource::collection($students));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $validated = $request->validated();
        $student   = Student::create($validated);

        return response()->json(new StudentIndexResource($student));
    }


    /**
     * Function used to mark a section as seen.
     */
    public function markSection(Request $request, int $id){

        $idResponse = false;

        $request->validate(['student_id' => ['required', 'integer', 'exists:students,id',],
                            'section_id' => ['required', 'integer', 'exists:sections,id',],]);

        try{
            //Check if the student_id from $request is the same
            //as the student_id from url.
            if($id === $request->student_id) $student = Student::find($id);
            else throw new \Exception("Incorrect data.");

            //Attach() doesn't validate whether the student_id-section_id
            //already exists, but if it does, it'll trigger an error
            //because section_student table has a composite PK
            //made of 'student_id'+'section_id'.
            $student->sections()->attach([$request->section_id => ['seen_date' => now()]]);

            $idResponse = $id;
            $response   = "Section marked as seen.";

        }catch(\Illuminate\Database\QueryException $e){
            $response = $e->getCode() === "23000" ? "This section was already marked as seen."
                                                  : "An error has occurred.";
        }

        return response()->json([ "id" => $idResponse,  
                                  "message" => $response], );
    }


    /**
     * Filter students progress by student_id.
     */
    public function getProgress(int $id){
        $data = DB::table('section_student')
                ->where('student_id', $id)
                ->get(['section_id', 'seen_date']);

        return response()->json($data);
    }


    /**
     * Remove a section to mark it as not seen.
     */
    public function unmarkSection(Student $student, Section $section){
        
        //Return error if section->id is missing.
        if (!$section->id) {
            return response()->json([
                "success" => false,
                "message" => "Invalid section."
            ], 400);
        }

        //Detach returns false if nothing could be deleted.
        $deleted = $student->sections()->detach($section->id);

        $id = $deleted > 0  ? $section->id : null;

        return response()->json(["id" => $id,
                                 "message" => $deleted > 0  ? "Section marked as not seen."
                                                            :  "Couldn't unmark section"]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //Return error 404 in case the student were is_active = 0.
        if(!$student->is_active) abort(404);

        $student->load(['level', 'color']);

        return response()->json(new StudentShowResource($student));
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
    public function update(StudentRequest $request, int $id)
    {
        $validated = $request->validated();
        $student   = Student::findOrFail($id);
        //Update with validated data.
        $student->update($validated);

        //Add fresh() because in some cases laravel doesn't
        //return data completely updated.
        $updStudent = new StudentShowResource($student->fresh());

        return response()->json($updStudent, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //Switch is_active to 0 and delete all student's classes
        DB::transaction(function () use ($student) {

           $student->update([
                'is_active' => 0
            ]);

            $student->studentClass()->delete();
        });

        return response()->json(["id" => $student->id]);
    }


    //Export students list.
    public function export()
    {
        //If there are no active students, don't generate the excel file.
        if (!Student::where('is_active', 1)->exists()) {

            return response()->json([
                'message' => 'There are no active students to export.'
            ], 404);
        }

        return Excel::download(
            new StudentsExport,
                'students.xlsx'
        );
    }
}
