<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Manage Administrators') }}
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

            <!-- Current Admins -->
            <div class="rounded-lg bg-blue-950 border border-blue-800 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-2">
                        <x-icons.shield class="h-5 w-5 text-green-400" />
                        <h3 class="text-lg font-semibold text-white">{{ __('Current Administrators') }}</h3>
                    </div>
                    <p class="mt-1 text-sm text-blue-200">
                        {{ __('These users can start/stop elections, manage candidates, and correct votes.') }}
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-blue-700">
                        <thead class="bg-blue-950">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Email') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Username') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-black divide-y divide-blue-700">
                            @forelse ($admins as $admin)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-white">
                                        {{ $admin->name }}
                                        @if ($admin->id === Auth::id())
                                            <span class="ml-2 inline-flex items-center rounded-full bg-green-600 px-2 py-0.5 text-xs font-semibold text-white">{{ __('You') }}</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-blue-200">{{ $admin->email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-blue-200">{{ $admin->username }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        @if ($admin->id !== Auth::id())
                                            <form action="{{ route('admin.admins.demote', $admin) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-red-700" onclick="return confirm('Remove {{ $admin->name }} as admin?')">
                                                    <x-icons.delete class="h-3.5 w-3.5 me-1.5" />
                                                    {{ __('Remove Admin') }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-blue-300">{{ __('Cannot remove yourself') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-sm text-blue-200">{{ __('No admins found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Promote Users to Admin -->
            <div class="rounded-lg bg-blue-950 border border-blue-800 shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-2">
                        <x-icons.users class="h-5 w-5 text-blue-400" />
                        <h3 class="text-lg font-semibold text-white">{{ __('Promote Users to Admin') }}</h3>
                    </div>
                    <p class="mt-1 text-sm text-blue-200">
                        {{ __('Select a user below to grant them administrator privileges.') }}
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-blue-700">
                        <thead class="bg-blue-950">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Name') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Email') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Username') }}</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wide text-blue-200">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-black divide-y divide-blue-700">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">{{ $user->name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-blue-200">{{ $user->email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-blue-200">{{ $user->username }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                        <form action="{{ route('admin.admins.promote', $user) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-green-700">
                                                <x-icons.shield class="h-3.5 w-3.5 me-1.5" />
                                                {{ __('Make Admin') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-sm text-blue-200">{{ __('All users are already admins.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                    <x-icons.dashboard class="h-4 w-4 me-2" />
                    {{ __('Back to Admin Dashboard') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
