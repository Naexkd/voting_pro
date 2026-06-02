<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Election Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-950 overflow-hidden shadow-sm sm:rounded-lg border border-blue-900">
                <div class="p-6 text-white">
                    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-sm text-blue-200">
                                <x-icons.chart class="h-5 w-5 text-green-400" />
                                <span>{{ __('Live vote totals by candidate are shown below.') }}</span>
                            </div>
                            @if ($election)
                                <p class="text-xs uppercase tracking-wide text-blue-300">
                                    {{ $election->is_active ? __('Election status: Active') : __('Election status: Closed') }}
                                </p>
                            @endif
                        </div>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-blue-950 px-3 py-1 text-sm font-semibold text-blue-300">
                            <x-icons.vote class="h-4 w-4" />
                            {{ __('Total votes:') }} {{ $totalVotes }}
                        </span>
                    </div>

                    @if ($election && $election->winnerCandidate)
                        <div class="mb-6 rounded-lg border border-green-700 bg-green-950/20 p-4 text-sm text-green-100">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="font-semibold text-white">{{ __('Election Winner') }}</p>
                                    <p>{{ $election->winnerCandidate->name }} — {{ $election->winnerCandidate->position }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs uppercase tracking-wide text-green-200">{{ __('Declared winner') }}</p>
                                    <p>{{ $election->ended_at?->format('Y-m-d') }}</p>
                                </div>
                            </div>
                            @if ($election->winner_notes)
                                <p class="mt-3 text-blue-200">{{ $election->winner_notes }}</p>
                            @endif
                        </div>
                    @endif

                    <div class="overflow-hidden rounded-lg border border-blue-700">
                        <table class="min-w-full divide-y divide-blue-700">
                            <thead class="bg-blue-950">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-300">{{ __('Photo') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-300">{{ __('Candidate') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-300">{{ __('Position') }}</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wide text-blue-300">{{ __('Votes') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-700 bg-blue-950">
                                @forelse ($candidates as $candidate)
                                    <tr>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <img src="{{ asset($candidate->photo_url) }}" alt="{{ $candidate->name }}" class="h-12 w-12 rounded-lg object-cover border border-blue-700" />
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-white">{{ $candidate->name }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-blue-200">{{ $candidate->position }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-semibold text-blue-200">{{ $candidate->vote_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-sm text-blue-200">{{ __('No candidates are available yet.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('vote.index') }}" class="inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                            <x-icons.vote class="h-4 w-4 me-2" />
                            {{ __('Back to voting') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
