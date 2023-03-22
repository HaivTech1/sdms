<?php

namespace App\Http\Livewire\Components\Admin\Staff;

use Carbon\Carbon;
use App\Models\Week;
use Livewire\Component;

class Calendar extends Component
{
    public $startDate;
    public $endDate;
    public $weeks;

    public function generateWeeks()
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate);
        Week::generateWeeks($start, $end);
        $this->reset(['startDate', 'endDate']);
        $this->mount();
    }

    public function mount()
    {
        $this->weeks = Week::where([
            'term_id' => term('id'),
            'period_id' => period('id'),
        ])->get();
    }


    public function getWeeksProperty()
    {
        return Week::where([
            'term_id' => term('id'),
            'period_id' => period('id'),
        ])->get();
    }

    public function flushWeeks()
    {
       foreach ($this->weeks as $week) {
            $week->delete();
       }
       $this->mount();
    }

    public function render()
    {
        return view('livewire.components.admin.staff.calendar');
    }
}
