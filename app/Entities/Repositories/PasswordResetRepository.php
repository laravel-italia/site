<?php

namespace LaravelItalia\Entities\Repositories;


use Carbon\Carbon;

class PasswordResetRepository
{
    public function add($email, $token)
    {
        \DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    public function exists($email, $token)
    {
        $reset = \DB::table('password_resets')
            ->where('email', '=', $email)
            ->where('token', '=', $token)
            ->first();

        return (!is_null($reset));
    }

    public function removeByEmail($email)
    {
        \DB::table('password_resets')
            ->where('email', '=', $email)
            ->delete();
    }
}