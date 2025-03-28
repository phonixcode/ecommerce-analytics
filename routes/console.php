<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('consolidated-orders:refresh')
            // ->everyMinute()
            ->weeklyOn(7, '00:00') // Every Sunday at midnight
            ->withoutOverlapping()
            ->onOneServer();
