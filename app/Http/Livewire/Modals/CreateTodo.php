<?php

namespace App\Http\Livewire\Modals;

use App\Models\Todo;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateTodo extends ModalComponent
{
    use AuthorizesRequests;
    public $title = [
        'en' => '',
        'ar' => ''
    ];
    public function render()
    {
        return view('livewire.modals.create-todo');
    }

    public function Create()
    {
        $this->validate([
            'title.en' => 'required|min:3',
            'title.ar' => 'required|min:3'
        ]);
        auth()->user()->todos()->create([
            'title' => $this->title
        ]);
        $this->dispatch('refreshTodos');
        $this->closeModal();
    }
}
