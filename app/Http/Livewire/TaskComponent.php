<?php

namespace App\Http\Livewire;

use App\Models\Task;
use App\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskComponent extends Component
{
    use WithPagination , AuthorizesRequests;

    public Todo $todo;

    protected $listeners = [
        'refreshTasks' => 'refreshTasks',
    ];

    public function render()
    {
        $this->authorize('view', $this->todo);

        return view('livewire.task-component', [
            'tasks' => $this->todo->tasks()
                ->orderByDesc('created_at')
                ->orderBy('completed_at' , 'asc')
                ->paginate(5),
        ])
            ->extends('layouts.app', ['title' => __('Tasks')])
            ->section('content');
    }

    public function mount(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function refreshTasks()
    {
        $this->todo = $this->todo->fresh();

        $this->resetPage();
    }

    public function toggle(Task $task)
    {
        $this->authorize('update', $task);
        try{
        $task->update([
            'completed_at' => $task->completed_at ? null : now(),
        ]);

        $this->todo = $this->todo->fresh();
        Toaster::success('toaster.success.update_task');
        }catch(\Throwable $th){
            \Log::error($th);
            Toaster::error('toaster.error.update_task');
        }
    }
}
