<?php

namespace App\Http\Controllers;

use App\Models\ActiveHour;
use Illuminate\Http\Request;

class ActiveHourController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Get each chapter's section. Chapter_id is necessary 
        //so that Lavavel can associate sections with chapters.
        $hours = ActiveHour::get();

        return $hours;
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        //$id at the end is to tell Laravel to ignore it during the uniqueness check.
        $validated = $request->validate(['from'  => 'required|date_format:H:i',
                                         'until' => 'required|date_format:H:i',]);

        $hours = ActiveHour::findOrFail($id);
        $hours->update($validated);

        return response()->json($hours, 200);
    }
}
