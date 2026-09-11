<?php

/* =========================================================
    IMPORT
========================================================= */
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/* =========================================================
    ARTISAN COMMAND: INSPIRE
========================================================= */
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');