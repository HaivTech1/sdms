<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\News;
use Illuminate\Console\Command;

class ChangeNewStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update news status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $news = News::get();

        foreach ($news as $new) {
            $created = Carbon::createFromFormat('Y-m-d H:i:s',  $new->created_at);
            $now = Carbon::now();
            $count = $created->diffInDays($now);
            
            if($count > 3){
                $new->uppdate(['status' => false]);
            }
        }
    }
}
