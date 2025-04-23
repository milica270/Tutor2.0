<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'tutor_id' => 'required|integer',
            'user_id' => 'required|integer',
            'date' => 'required|string',
            'hour_id' => 'required|string',
            'subject_id' => 'required|integer',
            'details' => 'nullable|string',
        ]);


        $validatedData['date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $validatedData['date'])->format('Y-m-d');

        
        Schedule::create([
            'tutor_id' => $validatedData['tutor_id'],
            'user_id' => $validatedData['user_id'],
            'date' => $validatedData['date'],
            'hour_id' => $validatedData['hour_id'],
            'subject_id' => $validatedData['subject_id'],
            'details' => $validatedData['details'] ?? null,
            'accepted' => 0, 
        ]);

        
        return redirect()->route('dashboard')->with('success', 'Request sent successfully!');
    }


    public function accept(Request $request) {
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tutor_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'hour_id' => 'required|integer',
        ]);
    
        
        $schedule = Schedule::where([
            'user_id' => $request->user_id,
            'tutor_id' => $request->tutor_id,
            'date' => $request->date,
            'hour_id' => $request->hour_id,
        ])->first();
    
        
        if (!$schedule) {
            return back()->with('error', 'Schedule not found.');
        }
    
        
        $schedule->update(['accepted' => 1]);
    
       
        return back()->with('success', 'Request accepted successfully.');
    }
    

    public function decline(Request $request)
    {
        
        $schedule = Schedule::where('user_id', $request->user_id)
                            ->where('tutor_id', $request->tutor_id)
                            ->where('date', $request->date)
                            ->where('hour_id', $request->hour_id)
                            ->first();

        

        
        if ($schedule) {
            $schedule->delete();
            return back()->with('success', 'Request declined successfully.');
        }

        return back()->with('error', 'Schedule not found.');
    }



}
