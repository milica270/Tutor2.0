<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\TutorMiddleware;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::middleware(['guest'])->group(function () {

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/store', [AuthController::class, 'store'])->name('store');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');

});

Route::middleware(['auth'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard1', [DashboardController::class, 'index1'])->name('dashboard1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin1', [AdminController::class, 'admin1'])->name('admin1')->middleware(AdminMiddleware::class);
Route::get('/admin2', [AdminController::class, 'admin2'])->name('admin2')->middleware(AdminMiddleware::class);
Route::get('/admin3', [AdminController::class, 'admin3'])->name('admin3')->middleware(AdminMiddleware::class);
Route::get('/admin4', [AdminController::class, 'admin4'])->name('admin4')->middleware(AdminMiddleware::class);
Route::get('/admin5', [AdminController::class, 'admin5'])->name('admin5')->middleware(AdminMiddleware::class);

Route::put('/admin/add_admin', [AdminController::class, 'add_admin'])->name('add.admin')->middleware(AdminMiddleware::class);
Route::put('/admin/delete_admin', [AdminController::class, 'delete_admin'])->name('delete.admin')->middleware(AdminMiddleware::class);

Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy')->middleware(AdminMiddleware::class);

Route::put('/admin/accept-tutor', [AdminController::class, 'acceptTutor'])->middleware(AdminMiddleware::class)->name('accept.tutor');
Route::delete('/admin/refuse-tutor', [AdminController::class, 'refuseTutor'])->middleware(AdminMiddleware::class)->name('refuse.tutor');

Route::put('/tutors/{id}', [AdminController::class, 'update'])->name('tutors.update')->middleware(TutorMiddleware::class);
Route::delete('/tutors/{tutor_id}/major/{major_id}', [AdminController::class, 'deleteMajor'])->name('tutors.major.destroy')->middleware(TutorMiddleware::class);



Route::get('/tutor/create', [DashboardController::class, 'create'])->name('tutors.create');
Route::get('/tutor/create1', [DashboardController::class, 'create1'])->name('tutors.create1');
Route::post('/tutor/create/store', [DashboardController::class, 'submit_tutor_subjects'])->name('submit.tutor.subjects');


Route::put('/delete/tutor/{id}', [AdminController::class, 'stop_tutor'])->name('stop_tutor')->middleware(TutorMiddleware::class);
Route::put('/delete/tutor/{id}/{subject_id}', [AdminController::class, 'delete_subject_from_tutor'])->name('delete_subject_from_tutor')->middleware(TutorMiddleware::class);

Route::get('/tutor/dashboard', [TutorController::class, 'index'])->name('tutor.dashboard')->middleware(TutorMiddleware::class);
Route::get('/tutor/dashboard1', [TutorController::class, 'index1'])->name('tutor.dashboard1')->middleware(TutorMiddleware::class);
Route::get('/tutor/dashboard2', [TutorController::class, 'index2'])->name('tutor.dashboard2')->middleware(TutorMiddleware::class);
Route::get('/tutor/dashboard3', [TutorController::class, 'index3'])->name('tutor.dashboard3')->middleware(TutorMiddleware::class);

Route::post('/tutor/appointment/store', [TutorController::class, 'store_new_appointment'])->name('store_new_appointment')->middleware(TutorMiddleware::class);
Route::delete('/appointments/{id}', [TutorController::class, 'destroy'])->name('delete_appointment')->middleware(TutorMiddleware::class);

Route::get('/dashboard3', [DashboardController::class, 'results'])->name('tutors.results');

Route::post('/send-request', [ScheduleController::class, 'store'])->name('send_request');
Route::put('/accept_request', [ScheduleController::class, 'accept'])->name('accept_request')->middleware(TutorMiddleware::class);
Route::delete('/decline_request', [ScheduleController::class, 'decline'])->name('decline_request');


});






