<?php 

namespace App\Services;

use App\Models\ActiveHour;
use App\Models\StudentClass;
use Illuminate\Validation\ValidationException;

class ActiveHoursService{

    public function update(ActiveHour $activeHours, $from, $until){

        //Query to filter classes that are outside the selected time range.
        $outsideClasses = StudentClass::where('starts', '<', $from)
                            ->orWhere('ends', '>', $until)
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