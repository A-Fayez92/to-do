<x-modal form-action="Delete">
    <x-slot name="title">
        {{ __('Delete Todo') }}
    </x-slot>

    <x-slot name="content">
        <div class="mb-4">
            <p class="flex text-sm text-gray-700">
                {{ __('Are you sure you want to delete this todo?') }}
            </p>
        </div>
    </x-slot>

</x-modal>