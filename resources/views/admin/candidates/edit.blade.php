<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Candidate') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-blue-950 border border-blue-800 shadow-sm p-6">
                <form method="POST" action="{{ route('admin.candidates.update', $candidate) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Candidate Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $candidate->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="position" :value="__('Position')" />
                            <x-text-input id="position" name="position" type="text" class="mt-1 block w-full" :value="old('position', $candidate->position)" required />
                            <x-input-error :messages="$errors->get('position')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="details" :value="__('Details')" />
                            <textarea id="details" name="details" class="mt-1 block w-full border-blue-700 bg-blue-950 text-white focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" rows="5">{{ old('details', $candidate->details) }}</textarea>
                            <x-input-error :messages="$errors->get('details')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="photo" :value="__('Candidate Photo')" />
                            @if ($candidate->photo_url)
                                <img src="{{ asset($candidate->photo_url) }}" alt="{{ $candidate->name }}" class="mb-3 h-24 w-24 rounded-lg border border-blue-700 object-cover" />
                            @endif
                            <input id="photo" name="photo" type="file" accept="image/*" class="mt-1 block w-full rounded-md border border-blue-700 bg-blue-950 px-3 py-2 text-white focus:border-blue-500 focus:ring-blue-500" />
                            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>
                                <x-icons.edit class="h-4 w-4 me-2" />
                                {{ __('Update Candidate') }}
                            </x-primary-button>

                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-md bg-black px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-900">
                                <x-icons.dashboard class="h-4 w-4 me-2" />
                                {{ __('Back to Admin') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
