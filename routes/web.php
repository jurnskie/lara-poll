<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'dashboard'], function () {

    Route::get('/', function (){
        return view('dashboard');
    })->name('dashboard');

    Route::resource('questions', QuestionController::class);
    Route::post('questions/{question}/answers/updateOrder', [QuestionController::class, 'updateOrder'])->name('questions.order.answers');
    Route::resource('questions.answers', AnswerController::class);

})->middleware(['auth', 'verified'])->name('dashboard');


Route::group(['prefix' => 'polls'], function(){
    Route::get('/{question}', [SubmissionController::class, 'show'])->name('polls.show');
})->middleware(['auth', 'verified'])->name('polls');

Route::group(['prefix' => 'submissions'], function(){
    Route::post('/{question}', [SubmissionController::class, 'store'])->name('submissions.store');
})->middleware(['auth', 'verified'])->name('polls');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
