<?php

namespace LaravelItalia\Domain;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    public static function fromNameAndBody($name, $body)
    {
        $template = new self;

        $template->name = $name;
        $template->body = $body;

        return $template;
    }
}
