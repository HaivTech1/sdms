<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use App\Jobs\DeleteModel;
use App\Events\BookingAccepted;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class GeneralAction extends Component
{
    public $model;
    // public $Data;

    public function mount(Model $model)
    {
        $this->model = $model;
        // $this->Data = $Data;
    }

    public function accept()
    {
        $mode = class_basename($this->model);
        
        $this->model->update(['isVerified' => true]);

        if ($mode == 'Booking') {
            
            event(new BookingAccepted($this->model));
        }

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Data is now verified, please refresh!',
        ]);
    }

    public function decline()
    {
        $mode = class_basename($this->model);
        
        $this->model->update(['isVerified' => false]);

        if ($mode == 'Booking') {
            
            event(new BookingRejectted($this->model));
        }

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Data is now declined, please refresh!',
        ]);
    }

    public function available()
    {
        $this->model->update(['isAvailable' => true]);

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Data is now available, please refresh!',
        ]);
    }

    public function unavailable()
    {
        $this->model->update(['isAvailable' => false]);

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Data is now unavailable, please refresh!',
        ]);
    }

    public function delete()
    {
       
        DeleteModel::dispatch($this->model);

        $this->dispatchBrowserEvent('success', [
            'message'     => 'Data deleted successfully, please refresh!',
        ]);
    }


    
    public function render()
    {
        return view('livewire.components.general-action');
    }
}