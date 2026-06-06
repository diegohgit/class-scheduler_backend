<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentClassRequest;
use App\Http\Resources\StudentClassResource;
use App\Models\StudentClass;

class StudentClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Filter classes to get only classes of active students.
        $studentClasses = StudentClass::with(['student.color'])
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
        StudentClass::create($request->validated());
        return response()->json(['success' => true], 201);
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
    public function update(StudentClassRequest $request, int $id)
    {
        $validated = $request->validated();
        $class = StudentClass::findOrFail($id);
        $class->update($validated);

        return response()->json(['success' => true], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentClass $studentClass)
    {
        //
    }
}
