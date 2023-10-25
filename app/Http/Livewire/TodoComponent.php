<?php

namespace App\Http\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TodoComponent extends Component
{
    use WithPagination, AuthorizesRequests;
    public $completed_count, $completed_percentage, $total_count;

    protected $listeners = [
        'refreshTodos', 'refreshTodoComponent'
    ];
    public function render()
    {
        if (auth()->check()) {
            $this->total_count = auth()->user()->todos()->count();
            $this->completed_count = auth()->user()->completed_todos_count ?? 0;
            $this->completed_percentage = $this->total_count > 0 ? round(($this->completed_count / $this->total_count) * 100) : 0;
        } else {
            return redirect()->route('login');
        }
        return view('livewire.todo-component', ['todos' => auth()->user()->todos()->orderBy('created_at', 'desc')->paginate(5)])
            ->extends('layouts.app')->section('content');
    }

    public function refreshTodos()
    {
        $this->resetPage();
    }
}
