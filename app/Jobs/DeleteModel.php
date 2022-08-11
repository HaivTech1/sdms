<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DeleteModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function handle()
    {
        if ($this->model->image && !is_null($this->model->image)) {
            foreach (json_decode($this->model->image , true) as $value) {
                File::delete(storage_path('app/public/' .strtolower(class_basename($this->model->image)) . 's/'. $value));
             }
        }

        $this->model->delete();
    }
}