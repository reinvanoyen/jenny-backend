<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;

class InteractivityController extends Controller
{
    public function receive(Request $request)
    {
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

            \Illuminate\Support\Facades\Http::post($responseUrl, [
                'text' => 'Merci vadsigaardje, uw stem voor "'.$wordModel->word.'" is binnen! 🤢',
                'replace_original' => true,
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
    }
}
