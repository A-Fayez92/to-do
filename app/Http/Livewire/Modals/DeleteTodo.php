<?php

namespace App\Http\Livewire\Modals;

use App\Models\Todo;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DeleteTodo extends ModalComponent
{
    use AuthorizesRequests;
    public $id , $todo;
    public function render()
    {
        $this->authorize('delete' , $this->todo);
        return view('livewire.modals.delete-todo');
    }

    public function mount($id)
    {
        $this->id = $id;
        $this->todo = Todo::findOrfail($this->id);
        $this->authorize('delete' , $this->todo);
    }

    public function Delete()
    {
        $this->authorize('delete' , $this->todo);
        try {
            $this->validate([
                'id' => 'required|exists:todos,id'
            ]);            
            DB::beginTransaction();
            $this->todo->tasks()->delete();
            $this->todo->delete();
            DB::commit();
            $this->dispatch('refreshTodos');
            $this->closeModal();
            Toaster::success('toaster.success.delete_todo');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->error('toaster.error.delete_todo');
        }
    }
}
