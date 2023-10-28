<?php

namespace App\Models;

use App\Models\Todo;
use App\Models\User;
use App\Notifications\CrudNotification;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Spatie\Activitylog\LogOptions;

class Task extends Model
{
    use HasFactory, SoftDeletes, HasTranslations, LogsActivity;

    /**
     * The attributes for translation
     *
     * @var array<string>
     */

    public $translatable = [
        'title',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'title',
        'completed_at',
        'todo_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $casts = [
        'title' => 'array',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the todo that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function todo(): BelongsTo
    {
        return $this->belongsTo(Todo::class);
    }

    /**
     * Get the user that owns the Todo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->todo->user();
    }

    /**
     * Trigger Crud Events for Task
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($task) {
            $task->notifyCrudEvent('created', trans('notifications.task.created_message', ['task' => $task->title]));
        });

        static::updated(function ($task) {
            if ($task->completed_at) {
                $task->notifyCrudEvent('completed', trans('notifications.task.completed_message', ['task' => $task->title]));
            } else {
                $task->notifyCrudEvent('updated', trans('notifications.task.updated_message', ['task' => $task->title]));
            }
        });

        static::deleted(function ($task) {
            $task->notifyCrudEvent('deleted', trans('notifications.task.deleted_message', ['task' => $task->title]));
        });
    }

    /**
     * Notify a CRUD event
     *
     * @param string $eventType
     * @param string $message
     */
    private function notifyCrudEvent($eventType, $message)
    {
        $subject = trans('notifications.task.' . $eventType . '_subject');
        $route = route('todo.tasks', $this->todo->id);
        $this->todo->user->notify((new CrudNotification($subject, $message, $route))->locale($this->todo->user->locale));
    }

    /**
     * Get the options for logging for the model.
     * 
     * @return LogOptions
     * 
     */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }
}
