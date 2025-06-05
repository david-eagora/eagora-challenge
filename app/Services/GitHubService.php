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
            'User-Agent' => 'Laravel-Challenge-App'
        ])->get($this->endpoint);

        if ($response->failed()) {
            return collect();
        }

        return collect($response->json())->map(fn($issue) => (object)[
            'id' => $issue['id'],
            'number' => $issue['number'],
            'title' => $issue['title'],
            'state' => $issue['state'],
            'user' => [
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

    public function getTopAuthors(int $limit = 5): Collection
    {
        $issues = $this->getIssues();

        return $issues
            ->groupBy('user.login')
            ->map(fn($group) => count($group))
            ->sortDesc()
            ->take($limit)
            ->map(fn($count, $user) => [
                'login' => $user,
                'count' => $count,
            ])
            ->values();
    }

    public function getRecent(int $days = 7): Collection
    {
        $issues = $this->getIssues();

        return $issues->filter(function ($issue) use ($days) {
            return now()->diffInDays($issue['created_at']) <= $days;
        })->values();
    }
}
