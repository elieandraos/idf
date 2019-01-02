<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')
    ->name('home')
    ->middleware('auth');

Route::get('/courses/{slug}', 'CourseEnrollmentController@show')
    ->name('courseEnrollments.show')
    ->middleware(['auth', 'verify-course-enrollment']);

Route::get('/courses/{slug}/leaderboard', 'CourseEnrollmentController@leaderboard')
    ->name('courseEnrollments.leaderboard')
    ->middleware(['auth', 'verify-course-enrollment']);

Route::post('/courses/{slug}/update-enrolled-user-score', 'CourseEnrollmentController@updateScore')
    ->name('courseEnrollments.score-update')
    ->middleware(['auth', 'verify-course-enrollment']);