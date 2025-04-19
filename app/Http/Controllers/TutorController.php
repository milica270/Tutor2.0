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
        $today = $now->toDateString(); // Format YYYY-MM-DD
        $currentTime = $now->format('H:i:s'); // Format HH:MM:SS
        $schedules1 = Schedule::where('tutor_id', $user->id)
        ->where('accepted', 1)
        ->where(function ($query) use ($today, $currentTime) {
            $query->where('date', '<', $today) // Budući datumi
                  ->orWhere(function ($q) use ($today, $currentTime) {
                      $q->where('date', $today) // Današnji dan
                        ->whereIn('hour_id', function ($subquery) use ($currentTime) {
                            $subquery->select('id')
                                     ->from('hours')
                                     ->where('begin_time', '<', $currentTime);
                        });
                  });
        })
        ->get();


        $scheduleCount = $schedules1->count(); // Count schedules
        return Inertia::render('tutorDashboard', ['user' => $user, 'appointments' => $appointments, 'scheduleCount' => $scheduleCount ]);
    }

    public function index1() {
        $user = Auth::user()->load(['major', 'subjects']);
        $users = User::all();
        $now = Carbon::now();
        $today = $now->toDateString(); // Format YYYY-MM-DD
        $currentTime = $now->format('H:i:s'); // Format HH:MM:SS
        $requests = Schedule::where('tutor_id', $user->id)
        ->where('accepted', 0)
        ->get();
        $schedules1 = Schedule::where('tutor_id', $user->id)
        ->where('accepted', 1)
        ->where(function ($query) use ($today, $currentTime) {
            $query->where('date', '<', $today) // Budući datumi
                  ->orWhere(function ($q) use ($today, $currentTime) {
                      $q->where('date', $today) // Današnji dan
                        ->whereIn('hour_id', function ($subquery) use ($currentTime) {
                            $subquery->select('id')
                                     ->from('hours')
                                     ->where('begin_time', '<', $currentTime);
                        });
                  });
        })
        ->get();


        $scheduleCount = $schedules1->count(); // Count schedules
        Schedule::removeExpiredSchedules();
        return Inertia::render('tutorDashboard1', ['user' => $user, 'users' => $users,  'requests' => $requests, 'scheduleCount' => $scheduleCount ]);
    }

    public function index2() {
        $user = Auth::user()->load(['major', 'subjects']);
        $users = User::all();

        $now = Carbon::now();
        $today = $now->toDateString(); // Format YYYY-MM-DD
        $currentTime = $now->format('H:i:s'); // Format HH:MM:SS

        $schedules = Schedule::where('tutor_id', $user->id)
        ->where('accepted', 1)
        ->where(function ($query) use ($today, $currentTime) {
            $query->where('date', '>', $today) // Budući datumi
                  ->orWhere(function ($q) use ($today, $currentTime) {
                      $q->where('date', $today) // Današnji dan
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
            $query->where('date', '<', $today) // Budući datumi
                  ->orWhere(function ($q) use ($today, $currentTime) {
                      $q->where('date', $today) // Današnji dan
                        ->whereIn('hour_id', function ($subquery) use ($currentTime) {
                            $subquery->select('id')
                                     ->from('hours')
                                     ->where('begin_time', '<', $currentTime);
                        });
                  });
        })
        ->get();


        $scheduleCount = $schedules1->count(); // Count schedules
        return Inertia::render('tutorDashboard2', ['user' => $user, 'users' => $users, 'schedules' => $schedules, 'scheduleCount' => $scheduleCount ]);
    }

    public function index3() {
        $user = Auth::user()->load(['major', 'subjects']);
        $users = User::all();
        $now = Carbon::now();
        $today = $now->toDateString(); // Format YYYY-MM-DD
        $currentTime = $now->format('H:i:s'); // Format HH:MM:SS

        $schedules = Schedule::where('tutor_id', $user->id)
        ->where('accepted', 1)
        ->where(function ($query) use ($today, $currentTime) {
            $query->where('date', '<', $today) // Budući datumi
                  ->orWhere(function ($q) use ($today, $currentTime) {
                      $q->where('date', $today) // Današnji dan
                        ->whereIn('hour_id', function ($subquery) use ($currentTime) {
                            $subquery->select('id')
                                     ->from('hours')
                                     ->where('begin_time', '<', $currentTime);
                        });
                  });
        })
        ->get();


        $scheduleCount = $schedules->count(); // Count schedules
        return Inertia::render('tutorDashboard3', ['user' => $user, 'users' => $users, 'schedules' => $schedules, 'scheduleCount' => $scheduleCount ]);
    }

    public function store_new_appointment(Request $request) {


    
        // Validate the request data
        $request->validate([
            'hour_id' => 'required|integer|between:1,8', // Hour must be between 1 and 8
            'day' => 'required|integer|between:1,5', // Day must be between 1 (Monday) and 5 (Friday)
        ]);
    
        // Get the authenticated user's ID (tutor ID)
        $tutorId = Auth::id();
    
        // Create a new appointment record
        $appointment = \App\Models\Appointment::create([
            'hour_id' => $request->hour_id,  // Store the hour_id
            'day' => $request->day,          // Store the day
            'tutor_id' => $tutorId,          // Store the tutor's ID
        ]);
    
        // Return a response (can be a redirect, JSON response, etc.)
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
