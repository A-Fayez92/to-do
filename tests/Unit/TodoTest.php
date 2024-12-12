<?php
// tests/Unit/TodoTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Todo;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_todo_can_have_completed_tasks_count_with_translations()
    {
        $user = User::factory()->create();
        $todo = Todo::create([
            'title' => ['en' => 'Test Todo', 'ar' => 'تودو اختبار'],
            'user_id' => $user->id
        ]);
        $task1 = $todo->tasks()->create(['title' => 'Task 1', 'completed_at' => now()]);
        $task2 = $todo->tasks()->create(['title' => 'Task 2']);

        $this->assertEquals(1, $todo->completed_tasks_count);
    }

    /** @test */
    public function a_todo_can_calculate_its_completed_percentage_with_translations()
    {
        $user = User::factory()->create();
        $todo = Todo::create([
            'title' => ['en' => 'Test Todo', 'ar' => 'تودو اختبار'],
            'user_id' => $user->id
        ]);
        $task1 = $todo->tasks()->create(['title' => 'Task 1', 'completed_at' => now()]);
        $task2 = $todo->tasks()->create(['title' => 'Task 2']);

        $this->assertEquals(50, $todo->completed_percentage);
    }

    /** @test */
    public function a_todo_can_notify_on_creation_with_translations()
    {
        $user = User::factory()->create();
        $todo = Todo::create([
            'title' => ['en' => 'Test Todo', 'ar' => 'تودو اختبار'],
            'user_id' => $user->id
        ]);
        
        $this->assertDatabaseHas('todos', [
            'title->en' => 'Test Todo',
            'title->ar' => 'تودو اختبار',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function a_todo_can_be_created_with_translations_and_user_id()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        Livewire::test('modals.create-todo')
            ->set('title.en', 'New Todo')
            ->set('title.ar', 'تودو جديد')
            ->call('Create')
            ->assertDispatched('refreshTodos')
            ->assertDispatched('closeModal');
        $this->assertDatabaseHas('todos', [
            'title->en' => 'New Todo',
            'title->ar' => 'تودو جديد',
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function a_todo_can_be_updated_with_translations()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $todo = Todo::create([
            'title' => ['en' => 'Old Title', 'ar' => 'عنوان قديم'],
            'user_id' => $user->id
        ]);

        Livewire::test('modals.edit-todo', ['id' => $todo->id])
            ->set('title.en', 'Updated Title')
            ->set('title.ar', 'عنوان محدث')
            ->call('Edit')
            ->assertDispatched('refreshTodos')
            ->assertDispatched('closeModal');
        $todo->refresh();
        $this->assertEquals('Updated Title', $todo->getTranslation('title', 'en'));
        $this->assertEquals('عنوان محدث', $todo->getTranslation('title', 'ar'));
       
        $this->assertDatabaseHas('todos', [
            'title->en' => 'Updated Title',
            'title->ar' => 'عنوان محدث',
            'user_id' => $user->id
        ]);
        
    }

     /** @test */
     public function a_todo_can_be_deleted()
     {
         $user = User::factory()->create();
         $this->actingAs($user);
         $todo = Todo::create([
             'title' => ['en' => 'Test Todo deleted', 'ar' => 'تودو اختبار محذوف'],
             'user_id' => $user->id
         ]);
         Livewire::test('modals.delete-todo', ['id' => $todo->id])
             ->call('Delete')
             ->assertDispatched('refreshTodos')
             ->assertDispatched('closeModal');
         $this->assertDatabaseMissing('todos', [
             'title->en' => 'Test Todo deleted',
             'title->ar' => 'تودو اختبار محذوف',
             'user_id' => $user->id,
             'deleted_at' => null
         ]);
     }

     /** @test */
    public function editing_a_todo_triggers_success_message_with_translations()
    {
        $user = User::factory()->create();
        $todo = Todo::create([
            'title' => ['en' => 'Test Todo', 'ar' => 'تودو اختبار'],
            'user_id' => $user->id
        ]);
        $this->actingAs($user);
        Livewire::test('Modals\EditTodo', ['id' => $todo->id])
            ->set('title.en', 'Updated Title')
            ->set('title.ar', 'العنوان المحدث')
            ->call('Edit')
            ->assertDispatched('refreshTodos')
            ->assertDispatched('closeModal');

        $this->assertDatabaseHas('todos', [
            'title->en' => 'Updated Title',
            'title->ar' => 'العنوان المحدث',
            'user_id' => $user->id
        ]);
    }

}
