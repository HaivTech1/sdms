<?php

namespace App\Http\Livewire\Components;

use App\Models\Task as TeamTask;
use Livewire\Component;
use Livewire\WithPagination;

class Task extends Component
{

    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 5;

    public function updatedWaitingPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->waitings->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getTasksWaitingProperty()
    {
        return TeamTask::waiting($this->per_page);
    }

    public function getTasksApprovedProperty()
    {
        return TeamTask::approved($this->per_page);
    }

    public function getTasksCompletedProperty()
    {
        return TeamTask::completed($this->per_page);
    }

    public function ApproveAll()
    {
        TeamTask::whereIn('id', $this->selectedRows)->update(['status' => 1]);
        
        $this->dispatchBrowserEvent('alert', ['message' => 'All selected task
            were marked as in progress']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function CompleteAll()
    {
        TeamTask::whereIn('id', $this->selectedRows)->update(['status' => 2]);
        
        $this->dispatchBrowserEvent('alert', ['message' => 'All selected task
            were marked as completed']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    
    public function render()
    {
        return view('livewire.components.task', [
            'waitings' => $this->tasksWaiting,
            'approveds' => $this->tasksApproved,
            'completeds' => $this->tasksCompleted,
        ]);
    }
}