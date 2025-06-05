<?php

namespace App\Http\Controllers;

use App\Http\Resources\IssueResource;
use App\Services\GitHubService;
use Illuminate\Http\Request;

class GitHubIssueController extends Controller
{

    public function __construct(protected GitHubService $gitHubService) {}

    public function index()
    {
        $issues = $this->gitHubService->getIssues();

        return IssueResource::collection($issues);
    }

    public function stats()
    {
        return response()->json($this->gitHubService->getStats());
    }

    public function topAuthors()
    {
        return response()->json($this->gitHubService->getTopAuthors());
    }

    public function recent()
    {
        return response()->json($this->gitHubService->getRecent());
    }
}
