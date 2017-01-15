<?php

namespace LaravelItalia\Domain;

use Illuminate\Database\Eloquent\Model;

class MapEntry extends Model
{
    public static function fromRequestDataArray($requestDataArray)
    {
        $mapEntry = new self();

        $mapEntry->name = $requestDataArray['name'];
        $mapEntry->description = $requestDataArray['description'];
        $mapEntry->type = $requestDataArray['type'];

        $mapEntry->latitude = $requestDataArray['latitude'];
        $mapEntry->longitude = $requestDataArray['longitude'];
        $mapEntry->region = $requestDataArray['region'];
        $mapEntry->city = $requestDataArray['city'];

        $mapEntry->website_url = $requestDataArray['website_url'];
        $mapEntry->github_url = $requestDataArray['github_url'];
        $mapEntry->facebook_url = $requestDataArray['facebook_url'];
        $mapEntry->twitter_url = $requestDataArray['twitter_url'];

        $mapEntry->is_confirmed = false;
        $mapEntry->confirmation_token = md5(microtime() . $mapEntry->name);

        return $mapEntry;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
