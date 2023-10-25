<?php

namespace App\Http\Livewire\Modals;

use App\Models\Todo;
use Masmerise\Toaster\Toaster;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditTodo extends ModalComponent
{
    use AuthorizesRequests;
    public $title , $id , $todo;
    public function render()
    {
        $this->title = Todo::findOrfail($this->id)->getTranslations('title');
        return view('livewire.modals.edit-todo');
    }

    public function mount($id)
    {
        $this->id = $id;
        $this->todo = Todo::findOrfail($this->id);
        $this->authorize('update' , $this->todo);
    }

    public function Edit()
    {
        $this->authorize('update' , $this->todo);
        $this->validate([
            'title.en' => 'required|min:3',
            'title.ar' => 'required|min:3'
        ]);
        try{
        $todo = Todo::findOrfail($this->id);
        $todo->update([
            'title' => $this->title
        ]);
        $this->dispatch('refreshTodos');
        $this->closeModal();
        Toaster::success('toaster.success.update_todo');
        }catch(\Throwable $th){
            return redirect()->back()->error('toaster.error.update_todo');
        }
    }
}
