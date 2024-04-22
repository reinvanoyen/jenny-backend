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

    $payload = json_decode($request->input('payload'), true);
    $responseUrl = $payload['response_url'];
    $votedWord = $payload['actions'][0]['selected_option']['value'] ?? null;

    $userId = $payload['user']['id'] ?? null;
    $userName = $payload['user']['username'] ?? null;

    if ($userId && $userName) {
        $author = author($userId, $userName);
    }

    \Illuminate\Support\Facades\Log::debug($payload);
    \Illuminate\Support\Facades\Log::debug($votedWord);

    $wordModel = \App\Models\Word::where('word', $votedWord)->first();

    if ($wordModel) {
        $wordModel->rating = $wordModel->rating + 1;
        $wordModel->save();

        \Illuminate\Support\Facades\Http::post($responseUrl, [
            'text' => 'Merci vadsigaardje, uw stem voor "'.$wordModel->word.'" is binnen! 🤢',
            'type' => 'in_channel',
        ]);

        if (isset($author) && $author) {
            \Spatie\SlackAlerts\Facades\SlackAlert::message('Viezerik '.$author->name.' stemde voor "'.$wordModel->word.'"!');
        } else {
            \Spatie\SlackAlerts\Facades\SlackAlert::message('Jaa!! Een stem voor "'.$wordModel->word.'"!');
        }
    }

    return response()->json([
        'status' => 'ok',
    ]);
});

Route::get('/', function () {
    return view('welcome');
});
