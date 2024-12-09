<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PostAtTime extends Command
{
    protected $signature = 'publication:execute';
    protected $description = 'Выполнить публикацию по ID';
    

    public function handle()
    {

        $publications = Publication::whereNotNull('scheduled_time')->where('scheduled_time', '<=', now())->get();
        foreach ($publications as $publication) {
            $publication->publicated=1;
            $publication->scheduled_time=Null;
            $publication->save();
        }
    }
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('publication:execute')->everyMinute();
    }
}
