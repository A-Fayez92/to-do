@props(['formAction' => false])

<div>
    @if($formAction)
    <form wire:submit.prevent="{{ $formAction }}">
        @endif
        <div class="flex bg-white p-4 sm:px-6 sm:py-4 border-b border-gray-150">
            @if(isset($title))
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $title }}
            </h3>
            @endif
        </div>
        <div class="bg-white px-4 sm:p-6">
            <div class="space-y-6">
                {{ $content }}
            </div>
        </div>

        <div class="bg-white px-4 pb-5 sm:px-4 sm:flex">
            <div class="sm:flex sm:flex-row-reverse">
                @if($formAction)
                <button type="submit"
                    class="mt-3 mx-1 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none">
                    {{ __($formAction) }}
                </button>
                @endif
                <button type="button" wire:click.prevent="$dispatch('closeModal')"
                    class="mt-3 mx-1 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>
        @if($formAction)
    </form>
    @endif
</div>