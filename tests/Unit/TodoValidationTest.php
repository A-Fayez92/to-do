<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_title_translations_to_create_a_todo()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        Livewire::test('modals.create-todo')
            ->call('Create')
            ->assertHasErrors(['title.en', 'title.ar']);

        Livewire::test('modals.create-todo')
            ->set('title.en', 'New Todo')
            ->call('Create')
            ->assertHasErrors(['title.ar']);

        Livewire::test('modals.create-todo')
            ->set('title.ar', 'مهام جديدة')
            ->call('Create')
            ->assertHasErrors(['title.en']);

        Livewire::test('modals.create-todo')
            ->set('title.en', 'New Todo')
            ->set('title.ar', 'مهام جديدة')
            ->call('Create')
            ->assertStatus(200);

        $this->assertDatabaseHas('todos', [
            'title->en' => 'New Todo',
            'title->ar' => 'مهام جديدة',
            'user_id' => $user->id
        ]);


    }

    /** @test */
    public function it_requires_valid_title_structure_to_create_a_todo()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Livewire::test('modals.create-todo')
            ->set('title.en', '')
            ->set('title.ar', '')
            ->call('Create')
            ->assertHasErrors(['title.en', 'title.ar']);
    }
}

