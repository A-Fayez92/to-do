<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
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
}
