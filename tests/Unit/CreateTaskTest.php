<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Todo;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_task_for_a_todo()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        Livewire::test('modals.create-task', ['id' => $todo->id])
            ->set('title.en', 'New Task')
            ->set('title.ar', 'مهمة جديدة')
            ->call('Create')
            ->assertDispatched('refreshTasks')
            ->assertDispatched('closeModal');

        $this->assertDatabaseHas('tasks', [
            'title->en' => 'New Task',
            'title->ar' => 'مهمة جديدة',
            'todo_id' => $todo->id,
        ]);
    }

    /** @test */
    public function validation_fails_when_task_title_is_missing()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = Livewire::test('modals.create-task', ['id' => $todo->id])
            ->set('title.en', '')
            ->set('title.ar', '')
            ->call('Create');

        $response->assertHasErrors(['title.en', 'title.ar']);
    }
}

