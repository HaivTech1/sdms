<?php

namespace App\Http\Livewire\Manager;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Application as App;

class Application extends Component
{

    use WithFileUploads;

    public App $application;
    public $app = [];
    public $photo;

    public function mount()
    {
        $this->application = App::first();
        $this->app = App::first()->toArray();
    }

    public function updateApplicationInformation()
    {

        $this->application->update([
            'name'         => $this->app['name'],
            'alias'         => $this->app['alias'],
            'email'         => $this->app['email'],
            'line1'         => $this->app['line1'],
            'line2'         => $this->app['line2'],
            'slogan'         => $this->app['slogan'],
            'motto'         => $this->app['motto'],
            'whatsapp'         => $this->app['whatsapp'],
            'facebook'         => $this->app['facebook'],
            'instagram'         => $this->app['instagram'],
            'address'         => $this->app['address'],
            'description'         => $this->app['description'],
        ]);

        if (isset($this->photo)) {
            File::delete(storage_path('app/' .$this->application->image));
            $this->application->update(['image' => $this->photo->store('applications', 'public')]);
            return redirect()->route('setting.index');
        }

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');

    }

    public function deleteApplicationPhoto()
    {
        App::first()->update([
            'image' => null,
        ]);

        $this->emit('refresh-navigation-menu');
    }
    
    
    public function render()
    {
        return view('livewire.manager.application');
    }
}