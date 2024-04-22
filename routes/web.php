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

Route::get('test', function (\Illuminate\Http\Request $request) {

});

Route::post('slack/interactivity', function (\Illuminate\Http\Request $request) {

    $payload = json_decode($request->input('payload'), true);
    $responseUrl = $payload['response_url'];
    $votedWord = $payload['actions'][0]['selected_option']['value'] ?? null;

    $channelId = $payload['channel']['id'] ?? null;
    $userId = $payload['user']['id'] ?? null;
    $userName = $payload['user']['username'] ?? null;
    $ts = $payload['message']['ts'] ?? null;

    if ($userId && $userName) {
        $author = author($userId, $userName);
    }

    $wordModel = \App\Models\Word::where('word', $votedWord)->first();

    if ($wordModel) {
        $wordModel->rating = $wordModel->rating + 1;
        $wordModel->save();

        $client = \JoliCode\Slack\ClientFactory::create(config('app.slack_bot_token'));

        \Illuminate\Support\Facades\Http::post($responseUrl, [
            'text' => 'Merci vadsigaardje, uw stem voor "'.$wordModel->word.'" is binnen! 🤢',
            'replace_original' => true,
        ]);

        /*
        $client->chatUpdate([
            'as_user' => true,
            'ts' => $ts,
            'channel' => $channelId,
            'text' => 'Merci vadsigaardje, uw stem voor "'.$wordModel->word.'" is binnen! 🤢',
        ]);*/

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
