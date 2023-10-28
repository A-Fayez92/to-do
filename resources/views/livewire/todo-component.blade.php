<div>
    <div class="p-4 bg-orange-50 border rounded-lg border-red-700 my-20 mx-auto max-w-3xl flex-col overflow-y-auto">
        <div class="font-normal mb-2">
            <p class="text-2xl mb-0.5">{{ $completed_percentage }}%</p>
            <p class="text-xs">{{ __('Profile Completion') }}</p>
        </div>
        <div class="mb-4">
            <div class="h-1 bg-red-200 w-full rounded">
                <div style="width: {{ $completed_percentage }}%"
                    class="h-full transition-all duration-1000 rounded bg-red-600"></div>
            </div>
        </div>
        <div class="mb-2">
            <a href="#" wire:click="$dispatch('openModal', { component: 'modals.create-todo' })">
                <div class="flex cursor-pointer text-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="16"
                        height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#212121" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="12" cy="12" r="9"></circle>
                        <line x1="9" y1="12" x2="15" y2="12"></line>
                        <line x1="12" y1="9" x2="12" y2="15"></line>
                    </svg>
                    <p class="ml-1">{{ __('Add New Todo') }}</p>
                </div>
            </a>
        </div>
        @forelse ($todos as $todo)
        <div class="mb-2 items-center justify-between md:flex sm:flex-row">
            <a href="{{ route('todo.tasks', $todo) }}">
                <div class="flex cursor-pointer text-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="16"
                        height="16" viewBox="0 0 24 24" stroke-width="2" stroke={{ $todo->completed_at ? '#fff' :
                        '#212121' }}
                        fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <circle cx="12" cy="12" r="9" fill={{ $todo->completed_at ? '#00AA45' : '#fff' }}></circle>
                        <path d="M9 12l2 2l4 -4"></path>
                    </svg>
                    <p class="ml-1 {{ $todo->completed_at ? 'line-through' : '' }}">{{ $todo->title . ' (' .
                        $todo->CompletedPercentage . '%)' }}</p>
                </div>
            </a>
            <div class="md:flex">
                <a href="#" wire:click="$dispatch('openModal', { component: 'modals.edit-todo', arguments: { id: {{
                    $todo->id }} } })" wire:key="edit-todo-{{ $todo->id }}">
                    <div class="flex cursor-pointer text-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="16"
                            height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#212121" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M17 3l4 4l-10 10H7v-4L17 3zM7 21v-4h4"></path>
                        </svg>
                        <p class="ml-1">{{ __('Edit') }}</p>
                    </div>
                </a>
    
                <a href="#" wire:click="$dispatch('openModal', { component: 'modals.delete-todo', arguments: { id: {{
                    $todo->id }} } })" wire:key="delete-todo-{{ $todo->id }}">
                    <div class="flex cursor-pointer text-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16"
                            height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#212121" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <line x1="4" y1="7" x2="20" y2="7"></line>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                        </svg>
                        <p class="ml-1">{{ __('Delete') }}</p>
                    </div>
                </a>
            </div>
        </div>
        @empty
        <div class="mb-2">
            <div class="flex cursor-pointer text-md">
                <p class="ml-1">{{ __('No Todos') }}</p>
            </div>
        </div>
        @endforelse
        {{ $todos->links() }}
    </div>
    
</div>