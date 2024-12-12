<?php

// tests/Unit/UserTest.php
namespace Tests\Unit;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_get_completed_todos_count()
    {
        $user = User::factory()->create();
        $todo1 = Todo::create(['title' => ['en' => 'Test Todo 1', 'ar' => 'تودو اختبار 1'], 'user_id' => $user->id, 'completed_at' => now()]);
        $todo2 = Todo::create(['title' => ['en' => 'Test Todo 2', 'ar' => 'تودو اختبار 2'], 'user_id' => $user->id]);

        $this->assertEquals(1, $user->completed_todos_count);
    }

    /** @test */
    public function user_can_check_if_all_todos_are_completed()
    {
        $user = User::factory()->create();
        $todo1 = Todo::create(['title' => ['en' => 'Test Todo 1', 'ar' => 'تودو اختبار 1'], 'user_id' => $user->id, 'completed_at' => now()]);
        $todo2 = Todo::create(['title' => ['en' => 'Test Todo 2', 'ar' => 'تودو اختبار 2'], 'user_id' => $user->id]);

        $this->assertFalse($user->is_all_todos_completed);
        
        $todo2->update(['completed_at' => now()]);
        
        $this->assertTrue($user->is_all_todos_completed);
    }
}
