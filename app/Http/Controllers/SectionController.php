<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //This validations must match with validations included in update() method
        $validated = $request->validate([ 'name'       => 'required|max:150',
                                          'chapter_id' => 'required|integer|exists:chapters,id',]);

        $section = Section::create([ 'name'       => $validated['name'], 
                                     'chapter_id' => $validated['chapter_id']]);
        return response()->json(['success' => true], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //This validations must match with validations included in store() method
        $validated = $request->validate([ 'name'       => 'required|max:150',
                                          'chapter_id' => 'required|integer|exists:chapters,id',]);

        $section = Section::findOrFail($id);
        $section->update($validated);

        return response()->json(['success' => true], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();

        return response()->json(['success' => true], 200);
    }
}
