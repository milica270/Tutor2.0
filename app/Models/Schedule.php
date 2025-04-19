<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class Schedule extends Model
{
    protected $fillable = [
        'tutor_id',
        'user_id',
        'date',
        'hour_id',
        'subject_id',
        'details',
        'accepted',
    ];




    public static function removeExpiredSchedules() {
        $now = Carbon::now();
        $today = $now->toDateString(); // Trenutni datum (YYYY-MM-DD)
        $currentTime = $now->format('H:i:s'); // Trenutno vreme (HH:MM:SS)
    
        // Brišemo rasporede gde je datum prošao i accepted = 0
        self::where('accepted', 0)
            ->where('date', '<=', $today)
            ->delete();

        // Brišemo rasporede gde je današnji datum, ali je vreme već prošlo
        self::where('accepted', 0)
        ->where('date', $today)
        ->whereIn('hour_id', function ($subquery) use ($currentTime) {
            $subquery->select('id')
                    ->from('hours')
                    ->where('begin_time', '<', $currentTime);
        })
        ->delete();
    
        
    }


}
