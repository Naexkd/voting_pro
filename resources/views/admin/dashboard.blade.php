<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-lg bg-green-600 px-4 py-3 text-sm text-white">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-lg bg-red-600 px-4 py-3 text-sm text-white">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid gap-6 lg:grid-cols-4">
                <div class="rounded-lg bg-blue-950 p-6 border border-blue-800 shadow-sm">
                    <div class="flex items-center gap-3">
                        <x-icons.vote class="h-8 w-8 text-green-400" />
                        <div>
                            <p class="text-sm text-blue-200">{{ __('Total Votes Cast') }}</p>
                            <p class="mt-1 text-3xl font-semibold text-white">{{ $totalVotes }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg bg-blue-950 p-6 border border-blue-800 shadow-sm">
                    <div class="flex items-center gap-3">
                        <x-icons.users class="h-8 w-8 text-blue-400" />
                        <div>
                            <p class="text-sm text-blue-200">{{ __('Registered Voters') }}</p>
                            <p class="mt-1 text-3xl font-semibold text-white">{{ $totalVoters }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg bg-blue-950 p-6 border border-blue-800 shadow-sm">
                    <div class="flex items-center gap-3">
                        <x-icons.candidate class="h-8 w-8 text-yellow-400" />
                        <div>
                            <p class="text-sm text-blue-200">{{ __('Total Candidates') }}</p>
                            <p class="mt-1 text-3xl font-semibold text-white">{{ $totalCandidates }}</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-lg bg-blue-950 p-6 border border-blue-800 shadow-sm">
                    <div class="flex items-center gap-3">
                        <x-icons.chart class="h-8 w-8 text-purple-400" />
                        <div>
                            <p class="text-sm text-blue-200">{{ __('Voter Turnout') }}</p>
                            <p class="mt-1 text-3xl font-semibold text-white">
                                @if ($totalVoters > 0)
                                    {{ round(($totalVotes / $totalVoters) * 100) }}%
                                @else
                                    0%
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <!-- Election Control -->
                <div class="rounded-lg bg-blue-950 border border-blue-800 shadow-sm p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm text-blue-200">{{ __('Election Status') }}</p>
                            <div class="mt-1 flex items-center gap-2">
                                <span class="inline-flex h-3 w-3 rounded-full {{ $election->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                <p class="text-2xl font-semibold text-white">{{ $election->is_active ? __('Active') : __('Stopped') }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-900 px-3 py-1 text-xs font-semibold text-blue-200 border border-blue-700">
                            <x-icons.flag class="h-3.5 w-3.5" />
                            {{ $election->title }}
                        </span>
                    </div>

                    <div class="mt-4 space-y-2 text-sm text-blue-200">
                        <p>{{ __('Description:') }} <span class="font-semibold text-white">{{ $election->description ?? __('No description set') }}</span></p>
                        <p>{{ __('Started at:') }} <span class="text-white">{{ $election->started_at?->format('Y-m-d H:i') ?? __('Not started') }}</span></p>
                        <p>{{ __('Ended at:') }} <span class="text-white">{{ $election->ended_at?->format('Y-m-d H:i') ?? __('Not ended') }}</span></p>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        @if ($election->is_active)
                            <form method="POST" action="{{ route('admin.election.stop') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700">
                                    <x-icons.flag class="h-4 w-4 me-2" />
                                    {{ __('Stop Election') }}
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.election.start') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                                    <x-icons.vote class="h-4 w-4 me-2" />
                                    {{ __('Start Election') }}
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.votes.index') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                            <x-icons.check class="h-4 w-4 me-2" />
                            {{ __('Review Votes') }}
                        </a>
                        @if (! $election->is_active)
                            <form method="POST" action="{{ route('admin.election.reset') }}" class="inline-flex">
                                @csrf
                                <button type="submit" onclick="return confirm('{{ __('This will clear all votes and remove the current winner. Continue?') }}')" class="inline-flex items-center justify-center rounded-md bg-yellow-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-700">
                                    <x-icons.delete class="h-4 w-4 me-2" />
                                    {{ __('Reset Election') }}
                                </button>
                            </form>
                        @endif
                    </div>

                    @if ($election->is_active)
                        <div class="mt-4 rounded-lg bg-green-900/30 border border-green-700 p-3">
                            <p class="text-sm text-green-200">
                                <strong>{{ __('Voting is open!') }}</strong>
                                {{ __('Voters can now cast their ballots.') }}
                            </p>
                        </div>
                    @else
                        <div class="mt-4 rounded-lg bg-yellow-900/30 border border-yellow-700 p-3">
                            <p class="text-sm text-yellow-200">
                                <strong>{{ __('Voting is closed.') }}</strong>
                                {{ __('Start the election to allow voters to cast their ballots.') }}
                            </p>
                        </div>

                        @if ($election->ended_at)
                            @if ($election->winnerCandidate)
                                <div class="mt-4 rounded-lg bg-blue-900/40 border border-blue-700 p-4">
                                    <p class="text-sm text-blue-200 font-semibold">{{ __('Election Winner') }}</p>
                                    <div class="mt-2 flex items-center gap-3">
                                        <img src="{{ asset($election->winnerCandidate->photo_url) }}" alt="{{ $election->winnerCandidate->name }}" class="h-16 w-16 rounded-lg object-cover border border-blue-700" />
                                        <div>
                                            <p class="text-lg font-semibold text-white">{{ $election->winnerCandidate->name }}</p>
                                            <p class="text-sm text-blue-200">{{ $election->winnerCandidate->position }}</p>
                                            <p class="mt-2 text-sm text-blue-200">{{ $election->winner_notes ?: __('No winner details were provided.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mt-4 rounded-lg bg-blue-900/30 border border-blue-700 p-4">
                                    <p class="text-sm text-blue-200 font-semibold">{{ __('Election completed.') }}</p>
                                    <p class="mt-2 text-sm text-blue-200">{{ __('Select the winning candidate below and save their summary.') }}</p>
                                </div>

                                <form method="POST" action="{{ route('admin.election.winner') }}" class="mt-4 space-y-4">
                                    @csrf
                                    <div>
                                        <label for="winner_candidate_id" class="block text-sm font-medium text-blue-200">{{ __('Winning Candidate') }}</label>
                                        <select id="winner_candidate_id" name="winner_candidate_id" class="mt-2 block w-full rounded-md border border-blue-700 bg-blue-950 px-3 py-2 text-white shadow-sm focus:border-green-500 focus:outline-none focus:ring focus:ring-green-500/20">
                                            <option value="">{{ __('Select a candidate') }}</option>
                                            @foreach ($candidates as $candidate)
                                                <option value="{{ $candidate->candidate_id }}">{{ $candidate->name }} — {{ $candidate->position }}</option>
                                            @endforeach
                                        </select>
                                        @error('winner_candidate_id')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="winner_notes" class="block text-sm font-medium text-blue-200">{{ __('Winner Details') }}</label>
                                        <textarea id="winner_notes" name="winner_notes" rows="3" class="mt-2 block w-full rounded-md border border-blue-700 bg-blue-950 px-3 py-2 text-white shadow-sm focus:border-green-500 focus:outline-none focus:ring focus:ring-green-500/20" placeholder="{{ __('Optional notes about the winner') }}">{{ old('winner_notes') }}</textarea>
                                        @error('winner_notes')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="submit" class="inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                                        <x-icons.flag class="h-4 w-4 me-2" />
                                        {{ __('Declare Winner') }}
                                    </button>
                                </form>
                            @endif
                        @endif
                    @endif
                </div>

                <!-- Admin Management -->
                <div class="rounded-lg bg-blue-950 border border-blue-800 shadow-sm p-6">
                    <div class="flex items-center gap-2">
                        <x-icons.shield class="h-5 w-5 text-green-400" />
                        <h3 class="text-lg font-semibold text-white">{{ __('Administrators') }}</h3>
                    </div>
                    <p class="text-sm text-blue-200">{{ __('Admins can start/stop elections, manage candidates, and correct votes.') }}</p>

                    <div class="mt-4 space-y-3">
                        @forelse ($admins as $admin)
                            <div class="rounded-lg bg-blue-900 p-3 text-sm text-blue-100 flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-white">{{ $admin->name }}</p>
                                    <p>{{ $admin->email }}</p>
                                </div>
                                @if ($admin->id === Auth::id())
                                    <span class="inline-flex items-center rounded-full bg-green-600 px-2 py-0.5 text-xs font-semibold text-white">{{ __('You') }}</span>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-blue-300">{{ __('No administrators configured.') }}</p>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.admins.index') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                            <x-icons.shield class="h-4 w-4 me-2" />
                            {{ __('Manage Administrators') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Positions Overview -->
            <div class="rounded-lg bg-blue-950 border border-blue-800 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-2">
                        <x-icons.candidate class="h-5 w-5 text-yellow-400" />
                        <h3 class="text-lg font-semibold text-white">{{ __('Positions & Candidates') }}</h3>
                    </div>
                    <p class="mt-1 text-sm text-blue-200">
                        {{ __('These are the positions being elected and the candidates running for each.') }}
                    </p>
                </div>

                @php
                    $groupedCandidates = $candidates->groupBy('position');
                @endphp

                @forelse ($groupedCandidates as $position => $positionCandidates)
                    <div class="border-t border-blue-800">
                        <div class="bg-blue-900/50 px-6 py-3">
                            <h4 class="text-base font-semibold text-green-400">{{ $position }}</h4>
                            <p class="text-xs text-blue-300">{{ $positionCandidates->count() }} {{ __('candidate(s)') }} | {{ $positionCandidates->sum('votes_count') }} {{ __('total votes') }}</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-blue-700">
                                <thead class="bg-blue-950">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Photo') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Name') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Votes') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Details') }}</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-black divide-y divide-blue-700">
                                    @foreach ($positionCandidates as $candidate)
                                        <tr>
                                            <td class="whitespace-nowrap px-6 py-4">
                                                <img src="{{ asset($candidate->photo_url) }}" alt="{{ $candidate->name }}" class="h-12 w-12 rounded-lg object-cover border border-blue-700" />
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-white">{{ $candidate->name }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-blue-200">{{ $candidate->votes_count }}</td>
                                            <td class="px-6 py-4 text-sm text-blue-200">{{ \Illuminate\Support\Str::limit($candidate->details, 60) }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                                <a href="{{ route('admin.candidates.edit', $candidate) }}" class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-blue-700">
                                                    <x-icons.edit class="h-3.5 w-3.5 me-1.5" />
                                                    {{ __('Edit') }}
                                                </a>
                                                <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" class="inline-block ms-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-red-700" onclick="return confirm('Delete {{ $candidate->name }}? This will also remove their votes.')">
                                                        <x-icons.delete class="h-3.5 w-3.5 me-1.5" />
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center">
                        <p class="text-sm text-blue-200">{{ __('No candidates have been added yet.') }}</p>
                    </div>
                @endforelse

                <div class="border-t border-blue-800 p-4">
                    <a href="{{ route('admin.candidates.create') }}" class="inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                        <x-icons.plus class="h-4 w-4 me-2" />
                        {{ __('Add New Candidate') }}
                    </a>
                </div>
            </div>

            <!-- Recent Votes -->
            @if ($recentVotes->isNotEmpty())
            <div class="rounded-lg bg-blue-950 border border-blue-800 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-2">
                        <x-icons.clock class="h-5 w-5 text-blue-400" />
                        <h3 class="text-lg font-semibold text-white">{{ __('Recent Votes Cast') }}</h3>
                    </div>
                    <p class="mt-1 text-sm text-blue-200">{{ __('The most recent votes in the system.') }}</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-blue-700">
                        <thead class="bg-blue-950">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Voter') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Candidate') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Position') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Time') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-black divide-y divide-blue-700">
                            @foreach ($recentVotes as $vote)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">{{ $vote->voter->name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">{{ $vote->candidate->name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-blue-200">{{ $vote->candidate->position }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-blue-200">{{ $vote->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
