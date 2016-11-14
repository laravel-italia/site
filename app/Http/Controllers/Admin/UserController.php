<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaravelItalia\Domain\User;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Http\Requests\UserInviteRequest;
use LaravelItalia\Domain\Repositories\RoleRepository;
use LaravelItalia\Domain\Repositories\UserRepository;
use JildertMiedema\LaravelTactician\DispatchesCommands;
use LaravelItalia\Domain\Commands\AssignRoleToUserCommand;
use LaravelItalia\Http\Requests\ChangeProfilePictureRequest;

/**
 * Class UserController
 * @package LaravelItalia\Http\Controllers\Admin
 */
class UserController extends Controller
{
    use DispatchesCommands;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:administrator');
    }

    /**
     * Mostra l'elenco degli amministratori/editor registrati.
     *
     * @param Request $request
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(Request $request, UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $users = $userRepository->getAll(
            $request->get('page', 1),
            $this->getSearchCriteria($request, $roleRepository)
        );

        return view('admin.user_index', compact('users'));
    }

    /**
     * Blocca un certo utente, dato il suo id.
     *
     * @param UserRepository $userRepository
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getBlock(UserRepository $userRepository, $userId)
    {
        try {
            $user = $userRepository->findById($userId);
        } catch (NotFoundException $e) {
            return redirect('admin/users')->with('error_message', 'L\'utente selezionato non esiste più. Potrebbe essere stato rimosso, nel frattempo.');
        }

        $user->is_blocked = true;

        try {
            $userRepository->save($user);
        } catch (NotSavedException $e) {
            return redirect('admin/users')->with('error_message', 'Problemi durante la procedura di blocco. Riprovare.');
        }

        return redirect('admin/users')->with('success_message', 'Utente bloccato correttamente.');
    }

    /**
     * Sblocca un utente, dato il suo id.
     *
     * @param UserRepository $userRepository
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getUnblock(UserRepository $userRepository, $userId)
    {
        try {
            $user = $userRepository->findById($userId);
        } catch (NotFoundException $e) {
            return redirect('admin/users')->with('error_message', 'L\'utente selezionato non esiste più. Potrebbe essere stato rimosso, nel frattempo.');
        }

        $user->is_blocked = false;

        try {
            $userRepository->save($user);
        } catch (NotSavedException $e) {
            return redirect('admin/users')->with('error_message', 'Problemi durante la procedura di sblocco. Riprovare.');
        }

        return redirect('admin/users')->with('success_message', 'Utente sbloccato correttamente.');
    }

    /**
     * Cambia ruolo all'utente il cui id è $userId, dall'attuale a quello identificato con $roleName.
     *
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @param $userId
     * @param $roleName
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getSwitch(UserRepository $userRepository, RoleRepository $roleRepository, $userId, $roleName)
    {
        try {
            $user = $userRepository->findById($userId);
        } catch (NotFoundException $e) {
            return redirect('admin/users')->with('error_message', 'L\'utente selezionato non esiste più. Potrebbe essere stato rimosso, nel frattempo.');
        }

        $role = $roleRepository->findByName($roleName);

        try {
            $this->dispatch(new AssignRoleToUserCommand($role, $user));
        } catch (NotSavedException $e) {
            return redirect('admin/users')->with('error_message', 'Problemi in fase di assegnazione del ruolo. Riprovare.');
        }

        return redirect('admin/users')->with('success_message', 'Ruolo assegnato correttamente.');
    }

    /**
     * Invita un nuovo editor creandone l'utente come editor.
     *
     * @param UserInviteRequest $request
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postInvite(UserInviteRequest $request, UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $user = User::fromNameAndEmailAndPassword($request->get('name'), $request->get('email'), '');

        try {
            $role = $roleRepository->findByName('editor');
            $this->dispatch(new AssignRoleToUserCommand($role, $user));
        } catch (NotSavedException $e) {
            return redirect('admin/users')->with('error_message', 'Problemi durante la creazione dell\'utente. Riprovare.');
        }

        return redirect('admin/users')->with('success_message', 'Editor invitato correttamente.');
    }

    /**
     * Salva una nuova foto profilo per l'utente di cui viene passato l'id.
     *
     * @param ChangeProfilePictureRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postChangePicture(ChangeProfilePictureRequest $request)
    {
        $fileName = $request->get('user_id') . '.jpg';

        try {
            \Image::make($request->file('picture'))
                ->save('profile-pictures/' . $fileName);
        } catch (\Exception $e) {
            return redirect('admin/users')->with('error_message', 'Problemi in fase di elaborazione della nuova immagine. Riprovare.');
        }

        return redirect('admin/users')->with('success_message', 'Immagine dell\'utente impostata correttamente.');
    }


    /**
     * Metodo utility che ricava un array di criteri per la ricerca di utenti.
     *
     * @param Request $request
     * @param RoleRepository $roleRepository
     * @return array
     */
    private function getSearchCriteria(Request $request, RoleRepository $roleRepository)
    {
        $criteria = [];

        if ($request->has('name')) {
            $criteria['name'] = $request->get('name');
        }

        if ($request->has('email')) {
            $criteria['email'] = $request->get('email');
        }

        if ($request->has('role') && $request->get('role') !== 'all') {
            $criteria['role_id'] = $roleRepository->findByName($request->get('role'))->id;
        }

        return $criteria;
    }
}
