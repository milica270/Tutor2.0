<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Subject;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index() {
        $user = Auth::user()->load('major');
        $users = User::all();
        $subjects = Subject::all();

        Schedule::removeExpiredSchedules();

        
        $requests = Schedule::where('user_id', $user->id)
        ->where('accepted', 0)
        ->get();

        

        


                $now = Carbon::now();
        $today = $now->toDateString(); 
        $currentTime = $now->format('H:i:s'); 
        
                $schedules = Schedule::where('user_id', $user->id)
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
            

        return Inertia::render('Dashboard', [
        'user' => $user,
        'requests' => $requests,
        'schedules' => $schedules,
        'users' => $users,
        'subjects' => $subjects,
        ]);
    }

    public function index1() {
        $user = Auth::user()->load('major');
        $subjects = Subject::all();
        return Inertia::render('Dashboard1', ['user' => $user, 'subjects' => $subjects]);
    }

    public function create() {
        $subjects = Subject::all();
        return Inertia::render('NewTutor', ['subjects' => $subjects]);
    }

    public function create1() {
        $subjects = Subject::all();
        return Inertia::render('NewTutor1', ['subjects' => $subjects]);
    }

    public function submit_tutor_subjects(Request $request)
{
    
    $validated = $request->validate([
        'subjects' => 'required|array|min:1',
        'subjects.*.subjectId' => 'required|integer|exists:subjects,id',
        'subjects.*.subject_grade' => 'required|integer|min:4|max:5',
    ]);



    
    $user = Auth::user();   
    $tutorId = $user->id; 

    
    foreach ($validated['subjects'] as $subject) {
        
        $exists = DB::table('tutor_subject')
            ->where('tutor_id', $tutorId)
            ->where('subject_id', $subject['subjectId'])
            ->exists();

        if ($exists) {
            continue;
        }
        
        DB::table('tutor_subject')->insert([
            'tutor_id' => $tutorId,
            'subject_id' => $subject['subjectId'],
            'subject_grade' => $subject['subject_grade'],
            'accepted' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    
    return redirect()->back()->with('success', 'Subjects submitted successfully.');
}




public function results(Request $request)
{
    $subject = $request->query('subject');
    $details = $request->query('details');
    $user = Auth::user()->load('major');

    $potentialTutors = User::where('is_tutor', 1)
        ->where('grade', '>=', $user->grade)
        ->where('id', '!=', $user->id)
        ->with([
            'subjects' => function ($query) use ($subject) {
                $query->where('subjects.id', $subject)->withPivot('subject_grade');
            },
            'major'
        ])
        ->get();

    $tutors = $potentialTutors->filter(function ($tutor) use ($subject) {
        return $tutor->subjects->contains('id', $subject);
    });

    $tutorsWithGrades = $tutors->map(function ($tutor) use ($subject) {
        $subjectData = $tutor->subjects->firstWhere('id', $subject);

        
        $firstAvailableDate = $this->getFirstAvailableDate($tutor->id);


        if ($firstAvailableDate === 'Nema dostupnih termina') {
            return null;
        }

        return [
            'id' => $tutor->id,
            'name' => $tutor->name,
            'last_name' => $tutor->last_name,
            'avatar' => $tutor->avatar,
            'major' => $tutor->major,
            'grade' => $tutor->grade,
            'subject_grade' => $subjectData ? $subjectData->pivot->subject_grade : null,
            'first_available_date' => $firstAvailableDate,
        ];
    })->filter();;


    return Inertia::render('Dashboard2', [
        'user' => $user,
        'tutors' => $tutorsWithGrades,
        'details' => $details,
        'subject' => $subject,
    ]);
}



private function getFirstAvailableDate($tutorId)
{
    $currentDate = Carbon::now();

   
    $appointments = DB::table('appointments')
        ->where('tutor_id', $tutorId)
        ->get(['day', 'hour_id']); 

    
    if ($appointments->isEmpty()) {
        return 'Nema dostupnih termina';
    }

    $daysMap = [
        1 => Carbon::MONDAY,
        2 => Carbon::TUESDAY,
        3 => Carbon::WEDNESDAY,
        4 => Carbon::THURSDAY,
        5 => Carbon::FRIDAY,
        6 => Carbon::SATURDAY,
        7 => Carbon::SUNDAY,
    ];

    $possibleDates = [];

    
    foreach ($appointments as $appointment) {
        $day = $appointment->day;
        $hourId = $appointment->hour_id;

        
        

        if (!isset($daysMap[$day])) continue;
        

        $dayNumber = $daysMap[$day];

        

        

        
        $nextDate = $currentDate->copy()->next($dayNumber);

       

        
        while (DB::table('schedules')
            ->where('tutor_id', $tutorId)
            ->where('date', $nextDate->format('Y-m-d'))
            ->where('hour_id', $hourId)
            ->exists()) {
            
            $nextDate->addWeek();
        }

        
        $possibleDates[] = [
            'date' => $nextDate->format('Y-m-d'),
            'hour_id' => $hourId
        ];
        
    }

    
    if (empty($possibleDates)) {
        return 'Nema dostupnih termina';
    }

    return collect($possibleDates)->sortBy('date')->map(function($datePair) {
        return [
            'date' => Carbon::parse($datePair['date'])->format('d.m.Y'),
            'hour_id' => $datePair['hour_id']
        ];
    });
}






}
