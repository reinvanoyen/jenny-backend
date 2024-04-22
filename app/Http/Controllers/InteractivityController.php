<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Slack\Facades\Replier;
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

            $client = \JoliCode\Slack\ClientFactory::create(config('app.slack_bot_token'));

            if (isset($author) && $author) {
                $client->chatPostMessage([
                    'channel' => $channelId,
                    'as_user' => true,
                    'text' => 'Viezerik '.$author->name.' stemde voor "'.$wordModel->word.'"!',
                ]);
            }
        }

        return response()->json([
            'status' => 'ok',
        ]);
    }
}
