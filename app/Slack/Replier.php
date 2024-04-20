<?php

namespace App\Slack;

class Replier
{
    private ReplyFetcher $replyFetcher;
    private Translator $translator;

    /**
     * @param ReplyFetcher $replyFetcher
     * @param Translator $translator
     */
    public function __construct(ReplyFetcher $replyFetcher, Translator $translator)
    {
        $this->replyFetcher = $replyFetcher;
        $this->translator = $translator;
    }

    /**
     * @param int $type
     * @return string
     */
    public function reply(int $type): string
    {
        $reply = $this->replyFetcher->getByType($type);

        return $this->translator->translate($reply->text);
    }
}
