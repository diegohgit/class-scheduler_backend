<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentClassRequest;
use App\Http\Resources\StudentClassResource;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Support\Facades\DB;

class StudentClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Filter classes to get only classes of active students.
        $studentClasses = StudentClass::with('days')
                                        ->whereHas('student', 
                                            fn ($q) => $q->where('is_active', 1))
                                        ->orderBy('starts')
                                        ->get();

        return response()->json(StudentClassResource::collection($studentClasses));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentClassRequest $request)
    {
        $validated = $request->validated();

        $class = DB::transaction(function () use($validated) {
            //Store class info.
            $studentClass = StudentClass::create([
                'student_id' => $validated['student_id'],
                'starts'     => $validated['starts'],
                'ends'       => $validated['ends'],
            ]);

            $studentClass->days()->attach($validated['days_ids']);

            //Update class notes.
            if(array_key_exists('class_notes', $validated)){

                $this->updateClassNotes($validated['student_id'],
                                        $validated['class_notes']);
            }

            return $studentClass;
        });

        //Add array of days scheduled to response.
        $response = new StudentClassResource($class->load('days'));

        return response()->json($response, 201);
    }



    public function updateClassNotes(int $studentId, ?string $classNotes){
        //If user erased class notes, class_notes_date will be updated to null.
        $classNotesDate = $classNotes === null ? null : now();

        $updated = Student::where('id', $studentId)
                            ->update([  'class_notes'      => $classNotes,
                                        'class_notes_date' => $classNotesDate]);

        if(!$updated){
            throw new \RuntimeException("Something went wrong.");
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(StudentClass $studentClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentClass $studentClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentClassRequest $request)
    {
        $validated = $request->validated();

        $class = DB::transaction(function () use($validated){

            $deleteId = $validated['delete_id'];

            //Delete class in case user wants to merge days.
            if($deleteId && $deleteId !== $validated['id']){
    
                $deleteClass = StudentClass::findOrFail($deleteId);
                $deleteClass->delete();
            }

            //Update class info.
            $studentClass = StudentClass::findOrFail($validated['id']);

            $studentClass->update([ 'student_id' => $validated['student_id'],
                                    'starts'     => $validated['starts'],
                                    'ends'       => $validated['ends'],]);

            $studentClass->days()->sync($validated['days_ids']);

            //Update class notes.
            if(array_key_exists('class_notes', $validated)){

                $this->updateClassNotes($validated['student_id'],
                                        $validated['class_notes']);
            }

            return $studentClass;
        });

        //Add array of days scheduled to response.
        $response = new StudentClassResource($class->load('days'));

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentClass $studentClass)
    {
        $studentClass->delete();

        return response()->json($studentClass);
    }
}
