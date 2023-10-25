<?php

namespace App\Http\Livewire;

use App\Models\Task;
use App\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;

class TaskComponent extends Component
{
    use WithPagination;

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
                ->paginate(5),
        ])
            ->extends('layouts.app', ['title' => 'Tasks'])
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

        $task->update([
            'completed_at' => $task->completed_at ? null : now(),
        ]);

        $this->todo = $this->todo->fresh();
    }
}
