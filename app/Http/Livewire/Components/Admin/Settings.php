<?php

namespace App\Http\Livewire\Components\Admin;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithPagination;

class Settings extends Component
{

    use WithPagination;

    public $selectedRows = [];
    public $selectPageRows = false;
    public $per_page = 25;
    public $key = ''; 
    public $value = ''; 

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

     public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->periods->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        }
        else{
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getSettingsProperty()
    {
        return Setting::whereNotIn('key', [
            'over_ten', 'over_twenty', 'over_fourty', 'over_sixty', 'over_hundred', 'registration_link', 'mail_config', 
            'paystack', 'digital_payment', 'exam_grade', 'exam_remark', 'affective_domain', 'psychomotor_domain', 'exam_format', 'midterm_format', 
            'maintenance_mode', 'check_payment', 'exam_upload', 'mid_upload', 'guardian_notification', 'mother_notification', 'father_notification', 'cash', 'result_template'
        ])->search(trim($this->search))->loadLatest($this->per_page);
    }

    public function createSetting()
    {

        $setting = Setting::where('key', ''.$this->key)->first();
    
        if (!$setting) {
             Setting::create([
                 'key' => $this->key,
                 'value' => $this->value,
             ]);
        } else {
             $setting->update([
                 'value' => $this->value,
             ]);
        }

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Setting created successfully!',
        ]);

        $this->key = '';
        $this->value = '';
    }

    public function deleteAll()
    {
        Setting::whereIn('id', $this->selectedRows)->delete();
        $this->dispatchBrowserEvent('alert', ['message' => 'All selected settings were deleted']);
        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function render()
    { 
        return view('livewire.components.admin.settings',[
            'settings' => $this->settings
        ]);
    }
}
