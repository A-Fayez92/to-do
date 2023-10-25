<?php

namespace App\Http\Livewire\Modals;

use Masmerise\Toaster\Toaster;
use LivewireUI\Modal\ModalComponent;

class CreateTodo extends ModalComponent
{
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
        try{
        auth()->user()->todos()->create([
            'title' => $this->title
        ]);
        $this->dispatch('refreshTodos');
        $this->closeModal();
        Toaster::success('toaster.success.create_todo');
        }catch(\Throwable $th){
            return redirect()->back()->error('toaster.error.create_todo');
        }
    }
}
