<x-modal form-action="Edit">
    <x-slot name="title">
        {{ __('Edit Task') }}
    </x-slot>

    <x-slot name="content">
        <div class="mb-4">
            @foreach (config('app.supported_locales') as $locale)
            <label for="title" class="flex text-sm font-medium text-gray-700">{{ __('Title') }} ({{ strtoupper($locale)
                }})</label>
            <div class="mt-1">
                <input type="text" wire:model.defer="title.{{ $locale }}" id="title" name="title"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                @error("title.$locale")
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @endforeach
        </div>
    </x-slot>

</x-modal>