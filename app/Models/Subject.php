<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Subject extends Model
{
    protected $fillable = [
        'name',
    ];

    public function tutors()
    {
        return $this->belongsToMany(User::class, 'tutor_subject', 'subject_id', 'tutor_id');
    }
}
