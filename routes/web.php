<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()?->is_admin) {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/vote', [VoteController::class, 'index'])->name('vote.index');
    Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');
    Route::post('/vote/remember', [VoteController::class, 'rememberSelection'])->name('vote.remember');
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/candidates/create', [AdminController::class, 'createCandidate'])->name('admin.candidates.create');
    Route::post('/admin/candidates', [AdminController::class, 'storeCandidate'])->name('admin.candidates.store');
    Route::get('/admin/candidates/{candidate}/edit', [AdminController::class, 'editCandidate'])->name('admin.candidates.edit');
    Route::put('/admin/candidates/{candidate}', [AdminController::class, 'updateCandidate'])->name('admin.candidates.update');
    Route::delete('/admin/candidates/{candidate}', [AdminController::class, 'destroyCandidate'])->name('admin.candidates.destroy');
    Route::get('/admin/votes', [AdminController::class, 'voteReview'])->name('admin.votes.index');
    Route::delete('/admin/votes/{vote}', [AdminController::class, 'destroyVote'])->name('admin.votes.destroy');
    Route::post('/admin/election/start', [AdminController::class, 'startElection'])->name('admin.election.start');
    Route::post('/admin/election/stop', [AdminController::class, 'stopElection'])->name('admin.election.stop');
    Route::post('/admin/election/winner', [AdminController::class, 'selectWinner'])->name('admin.election.winner');
    Route::post('/admin/election/reset', [AdminController::class, 'resetElection'])->name('admin.election.reset');
    Route::get('/admin/admins', [AdminController::class, 'manageAdmins'])->name('admin.admins.index');
    Route::post('/admin/admins/{user}/promote', [AdminController::class, 'promoteToAdmin'])->name('admin.admins.promote');
    Route::delete('/admin/admins/{user}/demote', [AdminController::class, 'demoteFromAdmin'])->name('admin.admins.demote');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
