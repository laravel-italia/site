<?php

namespace LaravelItalia\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use LaravelItalia\Domain\MapEntry;

class MapEntryHasBeenRegistered
{
    use SerializesModels;

    /** @var MapEntry */
    private $mapEntry;

    /**
     * Create a new event instance.
     *
     * @param MapEntry $mapEntry
     * @return void
     */
    public function __construct(MapEntry $mapEntry)
    {
        $this->mapEntry = $mapEntry;
    }

    /**
     * @return MapEntry
     */
    public function getMapEntry()
    {
        return $this->mapEntry;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }
}
