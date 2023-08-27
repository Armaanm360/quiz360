<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});


Route::resource('/admin-dashboard', Dashboard\DashboardController::class)->middleware('auth');

Route::get('/newpage', 'HomeController@newPage');

Auth::routes();

Route::get('/home', 'HomeController@index')->middleware('auth');

//college division
Route::resource('/college-division', Division\DivisionController::class)->middleware('auth');


Route::resource('/college-subject', Subject\SubjectController::class)->middleware('auth');


Route::resource('/college-quiz', SubjectQuiz\SubjectiveQuizZController::class)->middleware('auth');


Route::get('/create-subjective-question/{id}', 'CreateQuestion\CreateQuestionController@createQuestionView')->middleware('auth');
Route::post('/create-subjective-question-post', 'CreateQuestion\CreateQuestionController@createSubjectiveQuestionStore')->middleware('auth');


Route::get('/quiz-delete/{quiz_id}/{question_id}/', 'CreateQuestion\CreateQuestionController@deleteQuiz')->middleware('auth');

Route::resource('/exam', Exam\ExamController::class)->middleware('auth');


Route::post('/exam/quiz-post', 'Exam\ExamController@quizPost')->middleware('auth');
