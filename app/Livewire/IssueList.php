<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\GitHubService;
use Illuminate\Support\Collection;

class IssueList extends Component
{
    public $search = '';
    public $filterState = 'all';

    public Collection $issues;
    public int $openCount = 0;
    public int $closedCount = 0;
    public array $topUsers = [];
    public Collection $recentIssues;
    public ?object $selectedIssue = null;

    protected $service;

    // Store all issues once to avoid multiple API calls
    protected Collection $allIssuesOriginal;

    public function mount(GitHubService $service)
    {
        $this->service = $service;
        $this->allIssuesOriginal = $this->service->getIssues();
        $this->loadIssues();
    }

    public function showIssue($issueNumber)
    {
        $this->selectedIssue = app(GitHubService::class)->getIssueByNumber($issueNumber);
    }

    public function updatedSearch()
    {
        $this->loadIssues();
    }

    public function updatedFilterState()
    {
        $this->loadIssues();
    }

    public function loadIssues()
    {
        // Start with all issues
        $filtered = $this->allIssuesOriginal;

        // Filter by state if not 'all'
        if ($this->filterState !== 'all') {
            $filtered = $filtered->where('state', $this->filterState);
        }

        // Filter by search term in title
        if ($this->search !== '') {
            $filtered = $filtered->filter(
                fn($issue) =>
                str_contains(strtolower($issue->title), strtolower($this->search))
            );
        }

        $this->issues = $filtered->values();

        // Stats based on original full issues collection
        $this->openCount = $this->allIssuesOriginal->where('state', 'open')->count();
        $this->closedCount = $this->allIssuesOriginal->where('state', 'closed')->count();

        $this->topUsers = $this->calculateTopAuthors($this->allIssuesOriginal);
        $this->recentIssues = $this->calculateRecentIssues($filtered);
    }

    protected function calculateTopAuthors(Collection $issues): array
    {
        return $issues
            ->groupBy('user.login')
            ->map(fn($group, $user) => (object)[
                'user' => $user,
                'count' => $group->count(),
                'avatar_url' => $group->first()->user->avatar_url ?? null,
            ])
            ->sortByDesc('count')
            ->take(5)
            ->values()
            ->toArray();
    }

    protected function calculateRecentIssues(Collection $issues, int $days = 7): Collection
    {
        return $issues
            ->filter(fn($issue) => now()->diffInDays($issue->created_at) <= $days)
            ->values();
    }

    public function render()
    {
        return view('livewire.issue-list');
    }
}
