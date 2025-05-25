<?php

use function Pest\Laravel\getJson;

test('it fetches paginated issues', function () {
    getJson('/api/issues?page=1&per_page=5')
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'number', 'title', 'state', 'author', 'labels', 'created_at'],
            ],
            'total', 'per_page', 'current_page'
        ]);
});

test('it fetches issue stats with optional state filter', function () {
    getJson('/api/issues/stats?state=open')
        ->assertOk()
        ->assertJsonStructure(['open']);
});

test('it fetches top authors', function () {
    getJson('/api/issues/top-authors')
        ->assertOk()
        ->assertJsonIsObject();
});

test('it fetches recent issues', function () {
    getJson('/api/issues/recent')
        ->assertOk()
        ->assertJsonStructure(['*' => ['id', 'title', 'created_at']]);
});
