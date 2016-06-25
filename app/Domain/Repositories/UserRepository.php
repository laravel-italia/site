<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\User;
use Illuminate\Support\Facades\Hash;
use LaravelItalia\Exceptions\NotFoundException;

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
     * Restituisce l'utente il cui id è $id.
     *
     * @param $id
     * @return mixed
     * @throws NotFoundException
     */
    public function findById($id)
    {
        $user = User::find($id);

        if(!$user) {
            throw new NotFoundException;
        }

        return $user;
    }

    /**
     * Restituisce l'utente il cui indirizzo email è $emailAddress.
     *
     * @param $emailAddress
     * @return mixed
     * @throws NotFoundException
     */
    public function findByEmail($emailAddress)
    {
        $user = User::where('email', '=', $emailAddress)->first();

        if(!$user) {
            throw new NotFoundException;
        }

        return $user;
    }

    /**
     * Restituisce l'utente il cui indirizzo email è $emailAddress e la password è $password.
     *
     * @param $emailAddress
     * @param $password
     * @return \Illuminate\Database\Eloquent\Model|UserRepository|null|static
     * @throws NotFoundException
     */
    public function findByEmailAndPassword($emailAddress, $password)
    {
        $user = $this->findBy([
            'email' => $emailAddress,
            'is_confirmed' => true,
        ]);

        if(!$user || !Hash::check($password, $user->password)) {
            throw new NotFoundException;
        }

        return $user;
    }

    /**
     * Restituisce l'utente il cui codice di conferma è $confirmationCode.
     *
     * @param $confirmationCode
     * @return \Illuminate\Database\Eloquent\Model|UserRepository|null|static
     * @throws NotFoundException
     */
    public function findByConfirmationCode($confirmationCode)
    {
        $user = $this->findBy([
            'confirmation_code' => $confirmationCode
        ]);

        if(!$user) {
            throw new NotFoundException;
        }

        return $user;
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
