<?php

namespace LaravelItalia\Domain\Repositories;

use Carbon\Carbon;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;

class PasswordResetRepository
{
    /**
     * Restituisce una combinazione email/token partendo da $email e $token per la ricerca.
     *
     * @param $email
     * @param $token
     * @return mixed
     * @throws NotFoundException
     */
    public function findByEmailAndToken($email, $token)
    {
        $reset = \DB::table('password_resets')
            ->where('email', '=', $email)
            ->where('token', '=', $token)
            ->first();

        if(!$reset) {
            throw new NotFoundException;
        }

        return $reset;
    }

    /**
     * Aggiunge una nuova combinazione $email/$token per il recupero della password.
     *
     * @param $email
     * @param $token
     * @throws NotSavedException
     */
    public function add($email, $token)
    {
        $insert = \DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        if(!$insert) {
            throw new NotSavedException;
        }
    }

    /**
     * Cancella tutte le combinazioni email/token in cui l'indirizzo email è $email.
     *
     * @param $email
     * @throws NotFoundException
     */
    public function removeByEmail($email)
    {
        try {
            \DB::table('password_resets')
                ->where('email', '=', $email)
                ->delete();
        } catch (\Exception $e) {
            throw new NotFoundException;
        }
    }
}
