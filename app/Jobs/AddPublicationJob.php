<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Publication;
class AddPublicationJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $post_id;
    protected $scheduled_time;
    
    public function __construct($post_id,$scheduled_time)
    {
        $this->post_id = $post_id;
        $this->scheduled_time=$scheduled_time;
    }

    public function handle()
    {
        $post=Publication::find($this->post_id);
        $post->publicated=1;
        $post->save();
    }
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            AddPublicationJob::dispatch();
        })->at($this->scheduled_time); // Замените на нужное время
    }
}
