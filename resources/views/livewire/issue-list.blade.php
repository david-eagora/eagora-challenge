<div class="p-4 space-y-6">

    {{-- Barra de búsqueda y filtro --}}
    <div class="flex flex-col sm:flex-row sm:space-x-4 mb-4">
        <input type="text" placeholder="Search by title..." wire:model.debounce.300ms="search"
            class="border rounded p-2 flex-grow mb-2 sm:mb-0" />

        <select wire:model="filterState" class="border rounded p-2 w-full sm:w-48">
            <option value="all">All</option>
            <option value="open">Opened</option>
            <option value="closed">Closed</option>
        </select>
    </div>

    {{-- Open and Closed Issues --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white shadow rounded-xl p-4 text-center">
            <h2 class="text-lg font-semibold">Open Issues</h2>
            <p class="text-2xl text-green-600">{{ $openCount }}</p>
        </div>
        <div class="bg-white shadow rounded-xl p-4 text-center">
            <h2 class="text-lg font-semibold">Closed Issues</h2>
            <p class="text-2xl text-red-600">{{ $closedCount }}</p>
        </div>
    </div>

    {{-- Top Authors --}}
    <div class="bg-white shadow rounded-xl p-4">
        <h2 class="text-lg font-semibold mb-4">Top 5 Authors</h2>
        <ul class="space-y-2">
            @foreach ($topUsers as $user)
                <li class="flex items-center space-x-3">
                    <img src="{{ $user->avatar_url }}" class="w-8 h-8 rounded-full" alt="{{ $user->user }}">
                    <span class="font-medium">{{ $user->user }}</span>
                    <span class="ml-auto text-sm text-gray-500">&nbsp; {{ $user->count }} issues</span>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Recent Issues y Details --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {{-- Recent Issues --}}
        <div class="bg-white shadow rounded-xl p-4 max-h-[600px] overflow-y-auto">
            <h2 class="text-lg font-semibold mb-4">Recent Issues (Last 7 Days)</h2>
            <ul class="divide-y divide-gray-200">
                @forelse ($issues as $issue)
                    <li class="py-2">
                        <button wire:click="showIssue({{ $issue->number }})"
                            class="text-blue-600 hover:underline text-left w-full text-sm">
                            #{{ $issue->number }} - {{ $issue->title }}
                        </button>
                        <div class="text-xs text-gray-500">
                            by {{ $issue->user->login ?? 'Unknown' }} •
                            {{ \Carbon\Carbon::parse($issue->created_at)->diffForHumans() }}
                        </div>
                    </li>
                @empty
                    <li class="text-gray-500">No issues found.</li>
                @endforelse
            </ul>
        </div>

        {{-- Issue Details --}}
        <div class="bg-white shadow rounded-xl p-4 max-h-[600px] overflow-y-auto">
            @if ($selectedIssue)
                <h2 class="text-lg font-semibold mb-2">Issue #{{ $selectedIssue->number }} Details</h2>

                <p class="mb-4 text-gray-700 whitespace-pre-wrap text-sm">
                    {{ $selectedIssue->body ?? 'No description provided.' }}
                </p>

                <div class="text-xs text-gray-500 mb-2">
                    <strong>Author:</strong>
                    {{ is_array($selectedIssue->user) ? $selectedIssue->user['login'] : $selectedIssue->user->login }}<br>
                    <strong>Comments:</strong> {{ $selectedIssue->comments ?? 0 }}
                </div>

                <a href="{{ $selectedIssue->html_url ?? '#' }}" target="_blank"
                    class="text-blue-500 underline text-sm">
                    View on GitHub →
                </a>
            @else
                <p class="text-gray-500 text-center mt-20 text-sm">Select an issue to see details here.</p>
            @endif
        </div>
    </div>

</div>
