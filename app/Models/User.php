<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Task;
use App\Models\Todo;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'locale',
        'is_admin'
    ];

    /**
     * User can access the panel
     * 
     * @param Panel $panel
     * @return bool
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Get all of the todos for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function todos(): HasMany
    {
        return $this->hasMany(Todo::class);
    }

    /**
     * Get Count of Completed Todos for the User
     * 
     * @return int
     */

    public function getCompletedTodosCountAttribute(): int
    {
        return $this->todos()->whereNotNull('completed_at')->count();
    }

    /**
     * Get all of the tasks for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function tasks(): HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Todo::class);
    }

    /**
     * Check if all Todos are completed
     * 
     * @return bool
     */

    public function getIsAllTodosCompletedAttribute(): bool
    {
        return $this->todos()->whereNull('completed_at')->count() === 0;
    }
}
