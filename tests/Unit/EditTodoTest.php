<?php
namespace Tests\Unit;

use App\Models\User;
use App\Models\Todo;
use Livewire\Livewire;
use Masmerise\Toaster\Toaster;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditTodoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_edit_a_todo()
    {
        $user = User::factory()->create();
        $todo = Todo::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        Livewire::test('modals.edit-todo', ['id' => $todo->id])
            ->set('title.en', 'Updated Todo')
            ->set('title.ar', 'تحديث المهام')
            ->call('Edit')
            ->assertDispatched('refreshTodos')
            ->assertDispatched('closeModal');
        $todo->refresh();
        $this->assertEquals('Updated Todo', $todo->getTranslation('title', 'en'));
        $this->assertEquals('تحديث المهام', $todo->getTranslation('title', 'ar'));
    }
}

