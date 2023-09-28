<?php

namespace App\Http\Livewire\Components\Admin\Attendance;

use Livewire\Component;
use App\Models\Attendance;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 10;
    public $search = '';
    public $grade = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->attendances->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function deleteAll()
    {
        Attendance::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('success', ['message' => 'All selected attendances
            were deleted']);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function getAttendancesProperty()
    {
        return Attendance::calendarByRole()->latest()->paginate($this->per_page);
    }
    
    public function render()
    {
        return view('livewire.components.admin.attendance.index',[
            'attendances' => $this->attendances
        ]);
    }
}