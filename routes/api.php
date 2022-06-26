<?php

use App\Http\Controllers\CrawlController;
use Illuminate\Support\Facades\Route;

Route::post('/crawl', [CrawlController::class, 'crawl']);
Route::get('/details/{id}', [CrawlController::class, 'showDetails']);
