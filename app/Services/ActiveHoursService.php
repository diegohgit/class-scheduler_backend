<?php 

namespace App\Services;

use App\Models\ActiveHour;
use App\Models\StudentClass;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class ActiveHoursService{

    public function update(ActiveHour $activeHours, $from, $until){
        //Validate that active hours are more than 3 and less than 24 hours.
        $parsedFrom  = Carbon::parse($from);
        $parsedUntil = Carbon::parse($until);

        $untilCompare = $until;

        //if $until === midnight
        //Add a day to $parsedUntil so we can take the '00:00' time from the next day.
        //Turn $untilCompare into '24:00:00' so we can compare orWhere('ends', '>', $untilCompare).
        if($until === '00:00:00') {
            $parsedUntil->addDay();
            $untilCompare = '24:00:00';
        }

        $totalHours = $parsedFrom->diffInMinutes($parsedUntil) / 60;

        if($totalHours < 3 || $totalHours > 24){
            throw ValidationException::withMessages([
                'totalHours' => ['Active hours must be more than 3hrs and less than 24hrs.']
            ]);
        }



        //Query to filter classes that are outside the selected time range.
        $outsideClasses = StudentClass::where('starts', '<', $from)
                            ->orWhere('ends', '>', $untilCompare)
                            ->exists();

        if($outsideClasses){
            throw ValidationException::withMessages([
                'active_hours' =>['You have classes scheduled outside the selected time range.'],
            ]);
        }



        //In case the selected time range is ok, update() information.
        $activeHours->update([
            'from'  => $from,
            'until' => $until,
        ]);
    }
}
?>