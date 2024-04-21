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

    $payload = json_decode($request->input('payload'));
    $responseUrl = $payload['response_url'];

    $response = \Illuminate\Support\Facades\Http::post($responseUrl, [
        'text' => 'Merci vadsigaardje!',
        'replace_original' => 'true',
    ]);

    return response()->json([
        'status' => 'ok',
    ]);
});

Route::get('/', function () {
    return view('welcome');
});
