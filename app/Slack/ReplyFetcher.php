<?php

namespace App\Slack;

use App\Models\Reply;

class ReplyFetcher
{
    /**
     * @param int $replyType
     * @return Reply
     */
    public function getByType(int $replyType): Reply
    {
        return Reply::where('type', $replyType)->inRandomOrder()->first();
    }
}
