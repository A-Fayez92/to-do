<?php

namespace App\Http\Livewire\Modals;

use Masmerise\Toaster\Toaster;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DeleteTask extends ModalComponent
{
    use AuthorizesRequests;
    public $id , $task;
    public function render()
    {
        return view('livewire.modals.delete-task');
    }

    public function mount($id)
    {
        $this->id = $id;
        $this->task = auth()->user()->tasks()->findOrfail($this->id);
        $this->authorize('delete' , $this->task);
    }

    public function Delete()
    {
        $this->authorize('delete' , $this->task);
        try{
        $this->task->delete();
        $this->dispatch('refreshTasks');
        $this->closeModal();
        Toaster::success('toaster.success.delete_task');
        }catch(\Throwable $th){
            return redirect()->back()->error('toaster.error.delete_task');
        }
    }
}
