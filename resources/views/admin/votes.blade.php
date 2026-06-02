<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Vote Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-lg bg-green-600 px-4 py-3 text-sm text-white">
                    {{ session('success') }}
                </div>
            @endif

            <div class="rounded-lg bg-blue-950 border border-blue-800 shadow-sm overflow-x-auto">
                <table class="min-w-full divide-y divide-blue-700">
                    <thead class="bg-blue-950">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Vote ID') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Voter') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Candidate') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Position') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Time') }}</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-black divide-y divide-blue-700">
                        @forelse ($votes as $vote)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-white">{{ $vote->vote_id }}</td>
                                <td class="px-6 py-4 text-sm text-blue-200">
                                    <p class="font-semibold text-white">{{ $vote->voter->name }}</p>
                                    <p>{{ $vote->voter->national_id }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-white">{{ $vote->candidate->name }}</td>
                                <td class="px-6 py-4 text-sm text-blue-200">{{ $vote->candidate->position }}</td>
                                <td class="px-6 py-4 text-sm text-blue-200">{{ $vote->created_at->format('Y-m-d H:i') }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                    <form action="{{ route('admin.votes.destroy', $vote) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-red-700">
                                            <x-icons.delete class="h-3.5 w-3.5 me-1.5" />
                                            {{ __('Remove') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-sm text-blue-200">{{ __('No votes have been cast yet.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $votes->links() }}
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                    <x-icons.dashboard class="h-4 w-4 me-2" />
                    {{ __('Back to Admin') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
