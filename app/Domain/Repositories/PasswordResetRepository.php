<?php

namespace LaravelItalia\Domain\Repositories;

use Carbon\Carbon;

class PasswordResetRepository
{
    /**
     * Salva una nuova combinazione email/token di reset.
     *
     * @param $email
     * @param $token
     */
    public function add($email, $token)
    {
        \DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
    }

    /**
     * Verifica l'esistenza di una combinazione email/token di reset.
     *
     * @param $email
     * @param $token
     * @return bool
     */
    public function exists($email, $token)
    {
        $reset = \DB::table('password_resets')
            ->where('email', '=', $email)
            ->where('token', '=', $token)
            ->first();

        return !is_null($reset);
    }

    /**
     * Rimuove le combinazioni email/token di reset presenti a partire dall'email.
     *
     * @param $email
     */
    public function removeByEmail($email)
    {
        \DB::table('password_resets')
            ->where('email', '=', $email)
            ->delete();
    }
}
