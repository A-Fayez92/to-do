<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Notifications\CrudNotification;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Todo extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

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
        'user_id',
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
     * Get the user that owns the Todo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the tasks for the Todo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get Completed tasks count for the Todo
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCompletedTasksAttribute(): HasMany
    {
        return $this->hasMany(Task::class)->whereNotNull('completed_at');
    }

    /**
     * Get Completed tasks count for the Todo
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCompletedTasksCountAttribute(): int
    {
        return $this->tasks()->whereNotNull('completed_at')->count();
    }

    /**
     * Get Completed tasks Percentage for the Todo
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCompletedPercentageAttribute(): int
    {
        return $this->completed_tasks_count > 0 ? round(($this->completed_tasks_count / $this->tasks()->count()) * 100) : 0;
    }

    /**
     * Trigger Crud Events for Task
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($todo) {
            $todo->notifyCrudEvent('created', trans('notifications.todo.created_message', ['todo' => $todo->title]));
        });

        static::updated(function ($todo) {
            if ($todo->completed_at) {
                $todo->notifyCrudEvent('completed', trans('notifications.todo.completed_message', ['todo' => $todo->title]));

                if ($todo->user->is_all_todos_completed)
                    $todo->notifyCrudEvent('all_completed', trans('notifications.todo.all_completed_message'));
            } else {
                $todo->notifyCrudEvent('updated', trans('notifications.todo.updated_message', ['todo' => $todo->title]));
            }
        });

        static::deleted(function ($todo) {
            $todo->notifyCrudEvent('deleted', trans('notifications.todo.deleted_message', ['todo' => $todo->title]));
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
        $subject = trans('notifications.todo.' . $eventType . '_subject');
        $route = route('todos', $this->id);
        $this->user->notify(new CrudNotification($subject, $message, $route));
    }
}
