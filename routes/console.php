<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use App\Models\Publication;
use Carbon\Carbon;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::call(function(){
    $publications = Publication::whereNotNull('scheduled_time')->where('scheduled_time', '<=', Carbon::now()->setTimezone('Asia/Irkutsk'))->get();
    foreach ($publications as $publication) {
        $publication->publicated=1;
        $publication->scheduled_time=Null;
        $publication->save();
    }
})->everyMinute();