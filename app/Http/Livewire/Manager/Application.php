<?php

namespace App\Http\Livewire\Manager;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Application as App;
use Illuminate\Support\Facades\File;

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
            'address'         => $this->app['address'],
            'description'         => $this->app['description'],
            'facebook'         => $this->app['facebook'],
            'instagram'         => $this->app['instagram'],
            'twitter'         => $this->app['twitter'],
            'linkedin'         => $this->app['linkedin'],
            'website'         => $this->app['website'],
            'period_time'       => $this->app['period_time'],
        ]);

        if (isset($this->photo)) {
            File::delete(storage_path('applications/' .$this->application->image));
            $this->application->update(['image' => $this->photo->store('applications', 'public')]);
            return redirect()->route('setting.index');
        }

        if (isset($this->fav)) {
            File::delete(storage_path('applications/' .$this->application->fav));
            $this->application->update(['fav' => $this->fav->store('applications', 'public')]);
            return redirect()->route('setting.index');
        }

        $this->emit('saved');
    }

    public function deleteApplicationPhoto()
    {
        App::first()->update([
            'image' => null,
            'fav' => null,
            'signature' => null,
            'stamp' => null,
        ]);
    }
    
    
    public function render()
    {
        return view('livewire.manager.application');
    }
}