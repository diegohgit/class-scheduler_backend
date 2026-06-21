<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentClassRequest;
use App\Http\Resources\StudentClassResource;
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
            $studentClass = StudentClass::create([
                'student_id' => $validated['student_id'],
                'starts'     => $validated['starts'],
                'ends'       => $validated['ends'],
            ]);

            $studentClass->days()->attach($validated['days_ids']);

            return $studentClass;
        });

        return response()->json(['id' => $class->id], 201);
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

            $studentClass = StudentClass::findOrFail($validated['id']);
            
            $studentClass->update(['student_id' => $validated['student_id'],
                            'starts'     => $validated['starts'],
                            'ends'       => $validated['ends'],]);

            $studentClass->days()->sync($validated['days_ids']);

            return $studentClass;
        });

        return response()->json(['id' => $class->id], 200);
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
