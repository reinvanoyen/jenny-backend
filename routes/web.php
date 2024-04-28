<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('slack/interactivity', [\App\Http\Controllers\InteractivityController::class, 'receive']);

Route::get('/', function () {
    return view('words.list', [
        'words' => \App\Models\Word::orderBy('rating', 'desc')->get(),
    ]);
});

Route::get('/wurtle', function () {
    return view('games.wordle');
});

Route::get('/api/words', function () {
    return \App\Models\Word::all();
});
