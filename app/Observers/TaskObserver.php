<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }

    /*
    * Handle the Task "saved" event.
    */
    public function saved(Task $task): void
    {
        $task->todo->update([
            'completed_at' => $task->todo->tasks()->whereNotNull('completed_at')->count() == $task->todo->tasks()->count() ? now() : null
        ]);
    }
    
}
