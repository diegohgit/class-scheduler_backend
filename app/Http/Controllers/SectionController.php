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
        $validated = $request->validate([ 'name'   => 'required|array|min:1',
                                          'name.*' => 'required|max:150',
                                          'chapter_id' => 'required|integer|exists:chapters,id',]);

        //Insert each section and filter only id, name and chapter_id from response.
        $sections = collect($validated['name'])
            ->map(fn($section) => Section::create([
                'name' => $section,
                'chapter_id' => $validated['chapter_id']
            ]))
            ->map(fn($section) => $section->only(['id', 'name', 'chapter_id',]));

        return response()->json(['success' => true, 'data' => $sections->values()], 201);
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

        $oldChapter = $section->chapter_id !== (int) $request->chapter_id ? $section->chapter_id : null;

        $section->update($validated);

        $section =  ["section" => $section,
                     "id" => $section->id,
                     "old_chapter" => $oldChapter];

        return response()->json($section);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();

        return response()->json($section);
    }
}
