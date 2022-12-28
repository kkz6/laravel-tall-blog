<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShowPostController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\RedirectToUrlController;
use App\Http\Controllers\LaravelConsultingController;
use App\Http\Controllers\RedirectToAffiliateController;

Route::domain(preg_replace('/https?:\/\//', '', config('app.url')))->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::get('/laravel-developer-for-hire', LaravelConsultingController::class)->name('laravel-consulting');

    Route::post('/subscribe', SubscribeController::class)->name('subscribe');

    Route::view('seo-wizardry', 'seo-wizardry')->middleware('auth');

    Route::get('/recommends/{affiliate:slug}', RedirectToAffiliateController::class)->name('affiliate');

    Route::feeds();

    Route::get('/{post:slug}', ShowPostController::class)->name('posts.show');
});

Route::domain(config('app.shorts_domain'))->group(function () {
    Route::redirect('/', 'https://benjamincrozat.com');
    Route::get('/{short:slug}', RedirectToUrlController::class)->name('shorts.show');
});
