<?php

namespace LaravelItalia\Entities\Factories;

use LaravelItalia\Entities\Reply;

class ReplyFactory
{
    public static function createReply($body)
    {
        $reply = new Reply();

        $reply->body = $body;

        return $reply;
    }
}
