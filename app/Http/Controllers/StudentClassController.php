<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentClassRequest;
use App\Http\Resources\StudentClassResource;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class StudentClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studentClasses = StudentClass::with(['student.color'])->get();
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
        $studentClass = StudentClass::create($request->validated());
        return response()->json($studentClass, 201);
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
    public function update(StudentClassRequest $request, $id)
    {
        $validated = $request->validated();
        $class = StudentClass::findOrFail($id);
        $class->update($validated);

        return response()->json($class->id, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentClass $studentClass)
    {
        //
    }
}
