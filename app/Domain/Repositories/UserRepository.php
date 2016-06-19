<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * Ritorna l'elenco degli utenti presenti, eventualmente filtrandoli per nome, email e ruolo.
     *
     * @param $page
     * @param array $criteria
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($page, array $criteria)
    {
        $query = User::with(['role']);

        if (isset($criteria['name'])) {
            $query->where('name', 'LIKE', '%'.$criteria['name'].'%');
        }

        if (isset($criteria['email'])) {
            $query->where('email', 'LIKE', '%'.$criteria['email'].'%');
        }

        if (isset($criteria['role_id'])) {
            $query->where('role_id', '=', $criteria['role_id']);
        }

        return $query->paginate(
            \Config::get('settings.user.users_per_page'),
            ['*'],
            'page',
            $page
        );
    }

    /**
     * Restituisce un utente dato il suo id.
     *
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return User::find($id);
    }

    /**
     * Restituisce un utente dato il suo indirizzo email.
     *
     * @param $emailAddress
     * @return mixed
     */
    public function findByEmail($emailAddress)
    {
        return User::where('email', '=', $emailAddress)->first();
    }

    /**
     * Restituisce un utente dato il suo indirizzo email e password.
     *
     * @param $emailAddress
     * @param $password
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findByEmailAndPassword($emailAddress, $password)
    {
        $user = $this->findBy([
            'email' => $emailAddress,
            'is_confirmed' => true,
        ]);

        return ($user && Hash::check($password, $user->password)) ? $user : null;
    }

    /**
     * Restituisce un utente a partire dal suo codice di conferma.
     *
     * @param $confirmationCode
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findByConfirmationCode($confirmationCode)
    {
        return $this->findBy([
            'confirmation_code' => $confirmationCode,
        ]);
    }

    /**
     * Restituisce un utente in base a criteri variabili, specificati in $criteria.
     *
     * @param array $criteria
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    private function findBy(array $criteria)
    {
        $users = User::query();

        foreach ($criteria as $fieldName => $fieldValue) {
            $users->where($fieldName, '=', $fieldValue);
        }

        return $users->first();
    }

    /**
     * Salva l'utente $user nel database.
     *
     * @param User $user
     */
    public function save(User $user)
    {
        $user->save();
    }
}
