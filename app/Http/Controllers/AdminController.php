<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Subject;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function admin1() {
        return Inertia::render('Admin/AddAdmin');
    }

    public function admin2(Request $request) {
        return Inertia::render('Admin/Tutors', [
            'users' => User::with(['major', 'subjects'])->when($request->search, function($query) use ($request){
                $query->where('name','like', '%' . $request->search . '%');
            })->where('is_tutor', 1)->paginate(4)->withQueryString(),
            'searchTerm' => $request->search,
        ]
        );
    }

    public function admin4() {
        $tutorSubjects = DB::table('tutor_subject')
                        ->where('accepted', 0)
                        ->get();
        
        $users = User::all();
        $subjects = Subject::all();

        return Inertia::render('Admin/Tutors2', [
            'tutorSubjects' => $tutorSubjects,
            'users' => $users, 
            'subjects' => $subjects
        ]);
    }

    public function admin5() {
        $now = Carbon::now();
        $today = $now->toDateString(); 
        $currentTime = $now->format('H:i:s'); 

        $schedules = Schedule::where('accepted', 1)
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
            ->orderBy('date', 'desc')
            ->paginate(10);

            $cnt = $schedules->count();

            $users = User::all();
            $subjects = Subject::all();

            return Inertia::render('Admin/History', [
                'schedules' => $schedules,
                'users' => $users,
                'subjects' => $subjects,
                'cnt' => $cnt,
            ]);
    }

    public function acceptTutor(Request $request)
    {
        $id = $request->input('id1'); 
        

        $subject = DB::table('tutor_subject')->where('id', $id)->first();


        if ($subject) {
            DB::table('tutor_subject')
                ->where('id', $id)
                ->update(['accepted' => 1]);

            DB::table('users')
            ->where('id', $subject->tutor_id) 
            ->update(['is_tutor' => 1]);
    
            
            return redirect()->back()->with('success', 'Uspješno ste prihvatili tutora.');
        }
    
        
        return redirect()->back()->with('error', 'Tutor nije pronađen.');
    }

    public function update(Request $request, $id)
    {
        $tutor = User::findOrFail($id);
        $tutor->is_tutor = $request->input('is_tutor', 0);
        $tutor->save();

        return redirect()->back()->with('success', 'Tutor status updated successfully.');
    }

    public function deleteMajor($tutorId, $majorId)
    {
        $tutor = User::findOrFail($tutorId);

        if ($tutor->majors()->where('id', $majorId)->exists()) {
            $tutor->majors()->detach($majorId);
            return redirect()->back()->with('success', 'Major deleted successfully.');
        }

        return redirect()->back()->with('error', 'Major not found for this tutor.');
    }



    public function refuseTutor(Request $request) {
        $id = $request->input('id2'); 
        

        DB::table('tutor_subject')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Tutor successfully refused.');
    }

    public function admin3(Request $request) {
        return Inertia::render('Admin/Students', [
            'users' => User::with('major')->when($request->search, function($query) use ($request){
                $query->where('name','like', '%' . $request->search . '%');
            })->paginate(4)->withQueryString(),
            'searchTerm' => $request->search,
        ]
        );
    }

    public function add_admin(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email', 
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            $user->is_admin = 1;
            $user->save();
            return redirect()->route('admin1')->with('message', 'Uspješno ste dodali admina!');
        }

        return redirect()->route('admin1')->with('message', 'Došlo je do greške!');
    }

    public function delete_admin(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email', 
        ]);
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            $user->is_admin = 0;
            $user->save();
            return redirect()->route('admin1')->with('message', 'Uspješno ste uklonili admina!');
        }

        return redirect()->route('admin1')->with('message', 'Došlo je do greške!');
    }

    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete(); 

    return redirect()->back();
}

public function stop_tutor($id) {
    $tutor = User::findOrFail($id);
    $tutor->is_tutor = 0;
    $tutor->subjects()->detach();
    $tutor->save();


    return redirect()->back()->with('success', 'Upjesno ste uklonili tutora!');
}

public function delete_subject_from_tutor($id, $subject_id)
{
    $tutor = User::findOrFail($id);

    $tutor->subjects()->detach($subject_id);

    return redirect()->back()->with('success', 'Predmet je uspješno uklonjen iz tutorovih predmeta!');
}




}
