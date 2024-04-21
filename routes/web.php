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

Route::post('slack/interactivity', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::debug($request);

    return response()->json([
        'text' => 'Merci vadsigaardje!',
        'type' => 'in_channel',
    ]);
});

Route::get('/', function () {
    return view('welcome');
});
