<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Cast Your Vote') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-950 overflow-hidden shadow-sm sm:rounded-lg border border-blue-900">
                <div class="p-6 text-white">
                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-green-700 ring-1 ring-emerald-200">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 rounded-lg bg-rose-50 p-4 text-rose-700 ring-1 ring-rose-200">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-6 flex items-center gap-2 text-sm text-blue-200">
                        <x-icons.vote class="h-5 w-5 text-green-400" />
                        <span>{{ __('Each voter may cast only one vote. Please select a candidate below and confirm your choice.') }}</span>
                    </div>

                    @if ($hasVoted)
                        <div class="rounded-lg border border-yellow-300 bg-yellow-50 p-6">
                            <p class="font-medium text-yellow-800">{{ __('You have already voted.') }}</p>
                            <p class="text-sm text-yellow-700">{{ __('Thank you for participating in the election.') }}</p>
                        </div>
                    @elseif ($candidates->isEmpty())
                        <div class="rounded-lg border border-blue-700 bg-blue-950/50 p-6 text-blue-100">
                            <p class="font-medium">{{ __('No candidates are available yet.') }}</p>
                            <p class="text-sm">{{ __('Please check back later when candidates have been added.') }}</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('vote.store') }}" id="vote-form">
                            @csrf

                            <fieldset class="space-y-4">
                                @foreach ($candidates as $candidate)
                                    <label class="flex cursor-pointer items-center rounded-lg border border-blue-700 bg-blue-950 p-4 hover:border-blue-500">
                                        <input type="radio" name="candidate_id" value="{{ $candidate->candidate_id }}" class="vote-option h-4 w-4 text-green-500 focus:ring-green-500" {{ old('candidate_id', $selectedCandidate) == $candidate->candidate_id ? 'checked' : '' }} required>
                                        <div class="ml-4">
                                            <div class="flex items-center gap-3">
                                                <img src="{{ asset($candidate->photo_url) }}" alt="{{ $candidate->name }}" class="h-14 w-14 rounded-lg object-cover border border-blue-700" />
                                                <span class="font-semibold text-white">{{ $candidate->name }}</span>
                                            </div>
                                            <p class="text-sm text-blue-200">{{ $candidate->position }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </fieldset>

                            <x-input-error :messages="$errors->get('candidate_id')" class="mt-2" />

                            <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                                <x-primary-button>
                                    <x-icons.check class="h-4 w-4 me-2" />
                                    {{ __('Submit Vote') }}
                                </x-primary-button>
                                <a href="{{ route('results.index') }}" class="inline-flex items-center justify-center rounded-md bg-blue-950 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-900">
                                    <x-icons.chart class="h-4 w-4 me-2" />
                                    {{ __('View Results') }}
                                </a>
                            </div>
                        </form>
                        <script>
                            const voteOptions = document.querySelectorAll('.vote-option');
                            voteOptions.forEach((input) => {
                                input.addEventListener('change', () => {
                                    fetch('{{ route('vote.remember') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        },
                                        body: JSON.stringify({ candidate_id: input.value }),
                                    });
                                });
                            });
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
