<div>
  <div class="p-4 bg-orange-50 border rounded-lg border-red-700 my-20 mx-auto max-w-3xl overflow-y-auto">
    <div class="font-normal mb-2">
      <h1 class="text-2xl font-bold text-gray-800 dark:text-white md:text-2xl">{{ $todo->title }}</h1>
      <p class="text-xs">{{ __('Todo Compleation Percentage') }}</p>
      <p class="text-2xl mb-0.5">{{ $todo->CompletedPercentage }}%</p>
    </div>
    <div class="mb-4">
      <div class="h-1 bg-red-200 w-full rounded">
        <div style="width: {{ $todo->completed_percentage }}%"
          class="h-full transition-all duration-1000 rounded bg-red-600"></div>
      </div>
    </div>
    <div class="mb-2">
      <a href="#" wire:click.prevent="$dispatch('openModal', { component: 'modals.create-task', arguments: { id: {{
            $todo->id }} } })">
        <div class="flex cursor-pointer text-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="16"
            height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#212121" fill="none" stroke-linecap="round"
            stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <circle cx="12" cy="12" r="9"></circle>
            <line x1="9" y1="12" x2="15" y2="12"></line>
            <line x1="12" y1="9" x2="12" y2="15"></line>
          </svg>
          <p class="ml-1">{{ __('Add New Task') }}</p>
        </div>
      </a>
    </div>
    @forelse ($tasks as $task)
    <div class="mb-2 md:flex items-center justify-between sm:flex-row">
      <div class="flex cursor-pointer text-md"  wire:click.prevent="toggle({{$task->id }})" wire:key="toggle-task-{{ $task->id }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="16" height="16"
          viewBox="0 0 24 24" stroke-width="2" stroke={{ $task->completed_at ? '#fff' : '#212121' }}
          fill="none" stroke-linecap="round"
          stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
          <circle cx="12" cy="12" r="9" fill={{ $task->completed_at ? '#00AA45' : '#fff' }}></circle>
          <path d="M9 12l2 2l4 -4"></path>
          <p class="ml-1 {{ $task->completed_at ? 'line-through' : '' }}">{{ $task->title }}</p>
        </svg>

      </div>
      <div class="md:flex">
        <a href="#" wire:click.prevent="$dispatch('openModal', { component: 'modals.edit-task', arguments: { id: {{
                $task->id }} } })" wire:key="edit-task-{{ $task->id }}">
          <div class="flex cursor-pointer text-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="16" height="16"
              viewBox="0 0 24 24" stroke-width="2" stroke="#212121" fill="none" stroke-linecap="round"
              stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M17 3l4 4l-10 10H7v-4L17 3zM7 21v-4h4"></path>
            </svg>
            <p class="ml-1">{{ __('Edit') }}</p>
          </div>
        </a>

        <a href="#" wire:click.prevent="$dispatch('openModal', { component: 'modals.delete-task', arguments: { id: {{
                $task->id }} } })" wire:key="delete-task-{{ $task->id }}">
          <div class="flex cursor-pointer text-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="16" height="16"
              viewBox="0 0 24 24" stroke-width="2" stroke="#212121" fill="none" stroke-linecap="round"
              stroke-linejoin="round">
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
        <p class="ml-1">{{ __('No Tasks') }}</p>
      </div>
    </div>
    @endforelse
    {{ $tasks->links() }}
  </div>

</div>