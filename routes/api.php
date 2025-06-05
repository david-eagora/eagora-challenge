<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GitHubIssueController;

Route::get('/issues', [GitHubIssueController::class, 'index'])->name('api.issues.index');
Route::get('/issues/stats', [GitHubIssueController::class, 'stats'])->name('api.issues.stats');
Route::get('/issues/top-authors', [GitHubIssueController::class, 'topAuthors'])->name('api.issues.top-authors');
Route::get('/issues/recent', [GitHubIssueController::class, 'recent'])->name('api.issues.recent');
