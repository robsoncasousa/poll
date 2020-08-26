<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('poll')->name('poll.')->group(function () {
    Route::get('/{id}', 'PollController@show')->name('show');
    Route::get('/{id}/stats', 'PollController@stats')->name('stats');
    Route::post('/', 'PollController@store')->name('store');
    Route::post('/{id}/vote', 'PollController@vote')->name('vote');
});

Route::fallback(function () {
    return response()->json(['message' => 'Not Found.'], 404);
})->name('api.fallback.404');
