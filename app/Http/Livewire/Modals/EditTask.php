<?php

namespace App\Http\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditTask extends ModalComponent

{
    use AuthorizesRequests;
    public $title = [], $id, $task;
    public function render()
    {
        return view('livewire.modals.edit-task');
    }

    public function mount($id)
    {
        $this->id = $id;
        $this->task = auth()->user()->tasks()->findOrfail($this->id);
        $this->title = $this->task->getTranslations('title');
        $this->authorize('update', $this->task);
    }

    public function Edit()
    {
        $this->authorize('update', $this->task);
        $this->validate([
            'title.en' => 'required|min:3',
            'title.ar' => 'required|min:3'
        ]);

        $this->task->update([
            'title' => $this->title
        ]);
        $this->dispatch('refreshTasks');
        $this->closeModal();
    }
}
