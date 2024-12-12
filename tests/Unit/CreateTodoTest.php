<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Todo;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTodoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_a_todo()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test('modals.create-todo')
            ->set('title.en', 'New Todo')
            ->set('title.ar', 'مهام جديدة')
            ->call('Create')
            ->assertDispatched('refreshTodos')
            ->assertDispatched('closeModal');

        $this->assertDatabaseHas('todos', [
            'title->en' => 'New Todo',
            'title->ar' => 'مهام جديدة',
            'user_id' => $user->id,
        ]);
        // Toaster::assertDispatched('TODO Created Successfully');
    }

    /** @test */
    public function validation_fails_when_title_is_missing()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = Livewire::test('modals.create-todo')
            ->set('title.en', '')
            ->set('title.ar', '')
            ->call('Create');

        $response->assertHasErrors(['title.en', 'title.ar']);
    }
}

