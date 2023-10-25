<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(3)->create()->each(function ($user) {
            $user->todos()->saveMany(\App\Models\Todo::factory(15)->make())->each(function ($todo) {
                $todo->tasks()->saveMany(\App\Models\Task::factory(15)->make());
            });
        });

        $admin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'locale' => null,
        ]);

        $admin->todos()->saveMany(\App\Models\Todo::factory(15)->make())->each(function ($todo) {
            $todo->tasks()->saveMany(\App\Models\Task::factory(15)->make());
        });
    }
}
