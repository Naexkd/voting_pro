<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-950 overflow-hidden shadow-sm sm:rounded-lg border border-blue-900">
                <div class="p-6 text-white">
                    <div class="flex items-center gap-3">
                        <x-application-logo class="h-10 w-10 text-green-400" />
                        <h3 class="text-lg font-semibold text-green-400">{{ __('Secure Online Voting System') }}</h3>
                    </div>
                    <p class="mt-2 text-sm text-blue-200">
                        {{ __('Welcome to the Gasabo District voting portal. Use the links below to cast a vote and review real-time results.') }}
                    </p>

                    @php
                        $voter = Auth::user()->voter;
                        $hasVoted = $voter?->votes()->exists();
                    @endphp

                    <div class="mt-4 space-y-3">
                        <div class="rounded-lg bg-blue-950 p-4 border border-blue-700">
                            <p class="text-sm text-blue-200"><strong>{{ __('Voter Name:') }}</strong> {{ Auth::user()->name }}</p>
                            <p class="text-sm text-blue-200"><strong>{{ __('Voter ID:') }}</strong> {{ $voter?->voter_id ?? __('Pending') }}</p>
                            <p class="text-sm text-blue-200"><strong>{{ __('Voting Status:') }}</strong> {{ $hasVoted ? __('Vote cast') : __('Ready to vote') }}</p>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route('vote.index') }}" class="inline-flex items-center justify-center rounded-md bg-green-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <x-icons.vote class="h-4 w-4 me-2" />
                                {{ __('Vote Now') }}
                            </a>
                            <a href="{{ route('results.index') }}" class="inline-flex items-center justify-center rounded-md bg-blue-950 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <x-icons.chart class="h-4 w-4 me-2" />
                                {{ __('View Results') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
