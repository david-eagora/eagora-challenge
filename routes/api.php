<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GitHubIssueController;

Route::get('/issues', [GitHubIssueController::class, 'index']);
Route::get('/issues/stats', [GitHubIssueController::class, 'stats']);
Route::get('/issues/top-authors', [GitHubIssueController::class, 'topAuthors']);
Route::get('/issues/recent', [GitHubIssueController::class, 'recent']);
