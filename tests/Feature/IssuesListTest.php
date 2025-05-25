<?php

use App\Http\Livewire\IssuesList;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use function Pest\Laravel\get;

test('issues page can be rendered', function () {
    Http::fake([
        'https://api.github.com/repos/laravel/framework/issues' => Http::response([
            [
                'id' => 1,
                'number' => 123,
                'title' => 'Test Issue',
                'state' => 'open',
                'user' => [
                    'login' => 'testuser',
                    'avatar_url' => 'https://example.com/avatar.jpg'
                ],
                'labels' => [],
                'created_at' => '2024-01-01T00:00:00Z',
                'body' => 'Test body',
                'html_url' => 'https://github.com/test',
                'comments' => 0
            ]
        ], 200)
    ]);

    get('/issues')->assertStatus(200);
});

test('issues list component can load issues', function () {
    Http::fake([
        'https://api.github.com/repos/laravel/framework/issues' => Http::response([
            [
                'id' => 1,
                'number' => 123,
                'title' => 'Test Issue',
                'state' => 'open',
                'user' => [
                    'login' => 'testuser',
                    'avatar_url' => 'https://example.com/avatar.jpg'
                ],
                'labels' => [
                    ['name' => 'bug'],
                    ['name' => 'help wanted']
                ],
                'created_at' => '2024-01-01T00:00:00Z',
                'body' => 'Test body',
                'html_url' => 'https://github.com/test',
                'comments' => 5
            ]
        ], 200)
    ]);

    Livewire::test(IssuesList::class)
        ->assertSee('Test Issue')
        ->assertSee('testuser')
        ->assertSee('bug')
        ->assertSee('help wanted');
});

test('issues list can filter by state', function () {
    Http::fake([
        'https://api.github.com/repos/laravel/framework/issues' => Http::response([
            [
                'id' => 1,
                'number' => 123,
                'title' => 'Open Issue',
                'state' => 'open',
                'user' => [
                    'login' => 'testuser',
                    'avatar_url' => 'https://example.com/avatar.jpg'
                ],
                'labels' => [],
                'created_at' => '2024-01-01T00:00:00Z',
                'body' => 'Test body',
                'html_url' => 'https://github.com/test',
                'comments' => 0
            ],
            [
                'id' => 2,
                'number' => 124,
                'title' => 'Closed Issue',
                'state' => 'closed',
                'user' => [
                    'login' => 'testuser',
                    'avatar_url' => 'https://example.com/avatar.jpg'
                ],
                'labels' => [],
                'created_at' => '2024-01-01T00:00:00Z',
                'body' => 'Test body',
                'html_url' => 'https://github.com/test',
                'comments' => 0
            ]
        ], 200)
    ]);

    Livewire::test(IssuesList::class)
        ->set('state', 'open')
        ->assertSee('Open Issue')
        ->assertDontSee('Closed Issue');
});

test('issues list can search by title', function () {
    Http::fake([
        'https://api.github.com/repos/laravel/framework/issues' => Http::response([
            [
                'id' => 1,
                'number' => 123,
                'title' => 'Bug in authentication',
                'state' => 'open',
                'user' => [
                    'login' => 'testuser',
                    'avatar_url' => 'https://example.com/avatar.jpg'
                ],
                'labels' => [],
                'created_at' => '2024-01-01T00:00:00Z',
                'body' => 'Test body',
                'html_url' => 'https://github.com/test',
                'comments' => 0
            ],
            [
                'id' => 2,
                'number' => 124,
                'title' => 'Feature request',
                'state' => 'open',
                'user' => [
                    'login' => 'testuser',
                    'avatar_url' => 'https://example.com/avatar.jpg'
                ],
                'labels' => [],
                'created_at' => '2024-01-01T00:00:00Z',
                'body' => 'Test body',
                'html_url' => 'https://github.com/test',
                'comments' => 0
            ]
        ], 200)
    ]);

    Livewire::test(IssuesList::class)
        ->set('search', 'bug')
        ->assertSee('Bug in authentication')
        ->assertDontSee('Feature request');
});

test('issues list shows correct stats', function () {
    Http::fake([
        'https://api.github.com/repos/laravel/framework/issues' => Http::response([
            [
                'id' => 1,
                'number' => 123,
                'title' => 'Open Issue 1',
                'state' => 'open',
                'user' => [
                    'login' => 'user1',
                    'avatar_url' => 'https://example.com/avatar.jpg'
                ],
                'labels' => [],
                'created_at' => now()->subDays(1)->toIso8601String(),
                'body' => 'Test body',
                'html_url' => 'https://github.com/test',
                'comments' => 0
            ],
            [
                'id' => 2,
                'number' => 124,
                'title' => 'Open Issue 2',
                'state' => 'open',
                'user' => [
                    'login' => 'user1',
                    'avatar_url' => 'https://example.com/avatar.jpg'
                ],
                'labels' => [],
                'created_at' => now()->subDays(1)->toIso8601String(),
                'body' => 'Test body',
                'html_url' => 'https://github.com/test',
                'comments' => 0
            ],
            [
                'id' => 3,
                'number' => 125,
                'title' => 'Closed Issue',
                'state' => 'closed',
                'user' => [
                    'login' => 'user2',
                    'avatar_url' => 'https://example.com/avatar.jpg'
                ],
                'labels' => [],
                'created_at' => now()->subDays(8)->toIso8601String(),
                'body' => 'Test body',
                'html_url' => 'https://github.com/test',
                'comments' => 0
            ]
        ], 200)
    ]);

    Livewire::test(IssuesList::class)
        ->assertSet('stats.open', 2)
        ->assertSet('stats.closed', 1)
        ->assertSet('stats.recent', 2)
        ->assertSet('stats.top_users', ['user1' => 2, 'user2' => 1]);
});

test('issues list can show issue details', function () {
    Http::fake([
        'https://api.github.com/repos/laravel/framework/issues' => Http::response([
            [
                'id' => 1,
                'number' => 123,
                'title' => 'Test Issue',
                'state' => 'open',
                'user' => [
                    'login' => 'testuser',
                    'avatar_url' => 'https://example.com/avatar.jpg'
                ],
                'labels' => [],
                'created_at' => '2024-01-01T00:00:00Z',
                'body' => 'Test body',
                'html_url' => 'https://github.com/test',
                'comments' => 5
            ]
        ], 200)
    ]);

    Livewire::test(IssuesList::class)
        ->call('selectIssue', 1)
        ->assertSet('selectedIssue.id', 1)
        ->assertSet('selectedIssue.title', 'Test Issue')
        ->assertSet('selectedIssue.body', 'Test body')
        ->assertSet('selectedIssue.comments', 5)
        ->call('closeIssueDetails')
        ->assertSet('selectedIssue', null);
});
