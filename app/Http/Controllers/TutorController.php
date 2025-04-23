<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Schedule;
use Carbon\Carbon;

class TutorController extends Controller
{
    public function index() {
        $user = Auth::user()->load(['major', 'subjects']);
        $appointments = \App\Models\Appointment::where('tutor_id', $user->id)->get();
        $now = Carbon::now();
        $today = $now->toDateString(); 
        $currentTime = $now->format('H:i:s'); 
        $schedules1 = Schedule::where('tutor_id', $user->id)
        ->where('accepted', 1)
        ->where(function ($query) use ($today, $currentTime) {
            $query->where('date', '<', $today) 
                  ->orWhere(function ($q) use ($today, $currentTime) {
                      $q->where('date', $today) 
                        ->whereIn('hour_id', function ($subquery) use ($currentTime) {
                            $subquery->select('id')
                                     ->from('hours')
                                     ->where('begin_time', '<', $currentTime);
                        });
                  });
        })
        ->get();


        $scheduleCount = $schedules1->count(); 
        return Inertia::render('tutorDashboard', ['user' => $user, 'appointments' => $appointments, 'scheduleCount' => $scheduleCount ]);
    }

    public function index1() {
        $user = Auth::user()->load(['major', 'subjects']);
        $users = User::all();
        $now = Carbon::now();
        $today = $now->toDateString(); 
        $currentTime = $now->format('H:i:s'); 
        $requests = Schedule::where('tutor_id', $user->id)
        ->where('accepted', 0)
        ->get();
        $schedules1 = Schedule::where('tutor_id', $user->id)
        ->where('accepted', 1)
        ->where(function ($query) use ($today, $currentTime) {
            $query->where('date', '<', $today) 
                  ->orWhere(function ($q) use ($today, $currentTime) {
                      $q->where('date', $today) 
                        ->whereIn('hour_id', function ($subquery) use ($currentTime) {
                            $subquery->select('id')
                                     ->from('hours')
                                     ->where('begin_time', '<', $currentTime);
                        });
                  });
        })
        ->get();


        $scheduleCount = $schedules1->count(); 
        Schedule::removeExpiredSchedules();
        return Inertia::render('tutorDashboard1', ['user' => $user, 'users' => $users,  'requests' => $requests, 'scheduleCount' => $scheduleCount ]);
    }

    public function index2() {
        $user = Auth::user()->load(['major', 'subjects']);
        $users = User::all();

        $now = Carbon::now();
        $today = $now->toDateString(); 
        $currentTime = $now->format('H:i:s'); 

        $schedules = Schedule::where('tutor_id', $user->id)
        ->where('accepted', 1)
        ->where(function ($query) use ($today, $currentTime) {
            $query->where('date', '>', $today) 
                  ->orWhere(function ($q) use ($today, $currentTime) {
                      $q->where('date', $today) 
                        ->whereIn('hour_id', function ($subquery) use ($currentTime) {
                            $subquery->select('id')
                                     ->from('hours')
                                     ->where('begin_time', '>', $currentTime);
                        });
                  });
        })
        ->get();



        $schedules1 = Schedule::where('tutor_id', $user->id)
        ->where('accepted', 1)
        ->where(function ($query) use ($today, $currentTime) {
            $query->where('date', '<', $today) 
                  ->orWhere(function ($q) use ($today, $currentTime) {
                      $q->where('date', $today) 
                        ->whereIn('hour_id', function ($subquery) use ($currentTime) {
                            $subquery->select('id')
                                     ->from('hours')
                                     ->where('begin_time', '<', $currentTime);
                        });
                  });
        })
        ->get();


        $scheduleCount = $schedules1->count(); 
        return Inertia::render('tutorDashboard2', ['user' => $user, 'users' => $users, 'schedules' => $schedules, 'scheduleCount' => $scheduleCount ]);
    }

    public function index3() {
        $user = Auth::user()->load(['major', 'subjects']);
        $users = User::all();
        $now = Carbon::now();
        $today = $now->toDateString(); 
        $currentTime = $now->format('H:i:s');

        $schedules = Schedule::where('tutor_id', $user->id)
        ->where('accepted', 1)
        ->where(function ($query) use ($today, $currentTime) {
            $query->where('date', '<', $today) 
                  ->orWhere(function ($q) use ($today, $currentTime) {
                      $q->where('date', $today) 
                        ->whereIn('hour_id', function ($subquery) use ($currentTime) {
                            $subquery->select('id')
                                     ->from('hours')
                                     ->where('begin_time', '<', $currentTime);
                        });
                  });
        })
        ->get();


        $scheduleCount = $schedules->count(); 
        return Inertia::render('tutorDashboard3', ['user' => $user, 'users' => $users, 'schedules' => $schedules, 'scheduleCount' => $scheduleCount ]);
    }

    public function store_new_appointment(Request $request) {


    
        
        $request->validate([
            'hour_id' => 'required|integer|between:1,8', 
            'day' => 'required|integer|between:1,5', 
        ]);
    
        
        $tutorId = Auth::id();
    
        
        $appointment = \App\Models\Appointment::create([
            'hour_id' => $request->hour_id,  
            'day' => $request->day,          
            'tutor_id' => $tutorId,          
        ]);
    
        
        return redirect()->back()->with('success', 'Termin uspješno dodan!');
    }
    

    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if ($appointment) {
            $appointment->delete();
            return redirect()->back()->with('success', 'Termin je uspješno obrisan.');
        }

        return redirect()->back()->withErrors(['error' => 'Termin nije pronađen.']);
    }

    



}
