<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Appointment extends Model
{
    protected $fillable = [
        'day',
        'hour_id',
        'tutor_id',
    ];


    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }


}
