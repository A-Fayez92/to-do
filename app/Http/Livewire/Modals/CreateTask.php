<?php

namespace App\Http\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class CreateTask extends ModalComponent
{
    public $title = [], $id , $todo;
    public function render()
    {
        return view('livewire.modals.create-task');
    }

    public function mount($id)
    {
        $this->id = $id;
        $this->todo = auth()->user()->todos()->findOrFail($this->id);
    }

    public function Create()
    {
        $this->validate([
            'title.en' => 'required|min:3',
            'title.ar' => 'required|min:3'
        ]);
        try {
            $this->todo->tasks()->create([
                'title' => $this->title
            ]);
            $this->dispatch('refreshTasks');
            $this->closeModal();
            Toaster::success('toaster.success.create_task');
        } catch (\Throwable $th) {
            return redirect()->back()->error('toaster.error.create_task');
        }
    }
}
