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
        $today = $now->toDateString(); 
        $currentTime = $now->format('H:i:s'); 
    
        
        self::where('accepted', 0)
            ->where('date', '<=', $today)
            ->delete();

        
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
