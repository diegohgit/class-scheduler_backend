<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Get each chapter's section. Chapter_id is necessary 
        //so that Lavavel can associate sections with chapters.
        $chapters = Chapter::with(['section:id,name,chapter_id'])
                             ->get(['id', 'name']);
        return $chapters;
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
        $validated = $request->validate([ 
            'name' => 'required|array|min:1',
            'name.*' => 'required|max:150|unique:chapters,name', 
        ]);

        //Insert each chapter and filter only id and name from response.
        $chapters = collect($validated['name'])
            ->map(fn($chapter) => Chapter::create([
                'name' => $chapter
            ]))
            ->map(fn($chapter) => $chapter->only(['id', 'name']));

        //Use values() to return every row inserted.
        return response()->json(['success' => true, 'data' => $chapters->values()], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chapter $chapter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chapter $chapter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //$id at the end is to tell Laravel to ignore it during the uniqueness check.
        $validated = $request->validate(['name'=>'required|max:150|unique:chapters,name,'.$id]);

        $chapter = Chapter::findOrFail($id);
        $chapter->update($validated);

        return response()->json($chapter, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chapter $chapter)
    {
        $chapter->delete();

        return response()->json($chapter);
    }
}
