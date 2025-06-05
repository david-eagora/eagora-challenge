<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GitHubService
{
    protected string $endpoint = 'https://api.github.com/repos/laravel/framework/issues';

    public function getIssues(): Collection
    {
        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'Laravel-Challenge-App',
            'Authorization' => 'token ' . env('GITHUB_TOKEN'),
        ])->get($this->endpoint);

        if ($response->failed()) {
            return collect();
        }

        return collect($response->json())->map(fn($issue) => (object)[
            'id' => $issue['id'],
            'number' => $issue['number'],
            'title' => $issue['title'],
            'state' => $issue['state'],
            'user' => (object)[
                'login' => $issue['user']['login'],
                'avatar_url' => $issue['user']['avatar_url'],
            ],
            'labels' => collect($issue['labels'])->pluck('name'),
            'created_at' => $issue['created_at'],
        ]);
    }

    public function getStats(): array
    {
        $issues = $this->getIssues();

        return [
            'open' => $issues->where('state', 'open')->count(),
            'closed' => $issues->where('state', 'closed')->count(),
        ];
    }

    public function getIssueByNumber(int $issueNumber): ?object
    {
        $response = $response = Http::withHeaders([
            'Accept' => 'application/vnd.github.v3+json',
            'User-Agent' => 'Laravel-Challenge-App',
            'Authorization' => 'token ' . env('GITHUB_TOKEN'),
        ])->get($this->endpoint . '/' . $issueNumber);

        if ($response->failed()) {
            return null;
        }

        return (object) $response->json();
    }

    public function getTopAuthors(int $limit = 5): Collection
    {
        return $this->getIssues()
            ->groupBy('user.login')
            ->map(fn($issues, $user) => (object)[
                'user' => $user,
                'count' => $issues->count(),
                'avatar_url' => $issues->first()->user->avatar_url ?? null,
            ])
            ->sortByDesc('count')
            ->take($limit)
            ->values();
    }

    public function getRecent(int $days = 7): Collection
    {
        $issues = $this->getIssues();

        return $issues->filter(function ($issue) use ($days) {
            return now()->diffInDays($issue->created_at) <= $days;
        })->values();
    }
}
