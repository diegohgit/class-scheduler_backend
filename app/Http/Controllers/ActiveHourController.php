<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActiveHourResource;
use App\Models\ActiveHour;
use App\Services\ActiveHoursService;
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
        $hours = ActiveHour::findOrFail(1);

        return response()->json(new ActiveHourResource($hours));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(ActiveHoursService $service, ActiveHour $activeHour, Request $request)
    {
        $validated = $request->validate(['from'  => 'required|date_format:H:i:s',
                                         'until' => 'required|date_format:H:i:s',]);

        //$service does some validations in /app/Services/ActiveHoursService
        $service->update(
                $activeHour,
                $validated['from'],
                $validated['until']
            );

        return response()->json($activeHour->fresh(), 200);
    }
}