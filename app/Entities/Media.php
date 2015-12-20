<?php

namespace LaravelItalia\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Media
 * @package LaravelItalia\Entities
 */
class Media extends Model
{
    /**
     * @var string
     */
    protected $table = 'media';

    /* Relationship Utility Methods */

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user()->associate($user);
    }

    /* Relationship Methods */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
