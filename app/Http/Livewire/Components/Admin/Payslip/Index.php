<?php

namespace App\Http\Livewire\Components\Admin\Payslip;

use App\Models\Payslip;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $count = 10;

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->payslips->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getPayslipsProperty()
    {
        return Payslip::selectRaw('CONCAT(month," ",year) AS month_year, COUNT(*) AS count, SUM(JSON_EXTRACT(items, "$.\"net\"")) AS total_net')
        ->groupBy('year', 'month')
        ->orderByRaw('MAX(CONCAT(year, month)) DESC')
        ->paginate($this->count);
    }
    
    public function render()
    {
        return view('livewire.components.admin.payslip.index',[
            'payslips' => $this->payslips
        ]);
    }
}

