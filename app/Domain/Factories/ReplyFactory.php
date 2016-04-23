<?php

namespace LaravelItalia\Domain\Factories;

use LaravelItalia\Domain\Reply;

class ReplyFactory
{
    public static function createReply($body)
    {
        $reply = new Reply();

        $reply->body = $body;

        return $reply;
    }
}
