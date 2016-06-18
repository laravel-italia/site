<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Intervention\Image\Image;
use JildertMiedema\LaravelTactician\DispatchesCommands;
use LaravelItalia\Domain\Commands\AssignRoleToUserCommand;
use LaravelItalia\Domain\Factories\UserFactory;
use LaravelItalia\Domain\User;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Domain\Services\AssignRoleToUser;
use LaravelItalia\Domain\Repositories\RoleRepository;
use LaravelItalia\Domain\Repositories\UserRepository;
use LaravelItalia\Http\Requests\ChangeProfilePictureRequest;
use LaravelItalia\Http\Requests\UserInviteRequest;

/**
 * Class UserController.
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
     * @param Request        $request
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     *
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getIndex(Request $request, UserRepository $userRepository, RoleRepository $roleRepository)
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

        $users = $userRepository->getAll($request->get('page', 1), $criteria);

        return view('admin.user_index', compact('users'));
    }

    /**
     * @param UserRepository $userRepository
     * @param $userId
     *
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
     * @param UserRepository $userRepository
     * @param $userId
     *
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
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @param $userId
     * @param $roleName
     *
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

    public function postInvite(UserInviteRequest $request, UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $user = UserFactory::createUser($request->get('name'), $request->get('email'), '');

        try {
            $userRepository->save($user);
        } catch (NotSavedException $e) {
            return redirect('admin/users')->with('error_message', 'Problemi durante la creazione dell\'utente. Riprovare.');
        }

        try {
            $role = $roleRepository->findByName('editor');
            $this->dispatch(new AssignRoleToUser($role, $user));
        } catch (NotSavedException $e) {
            return redirect('admin/users')->with('error_message', 'Problemi in fase di assegnazione del ruolo. Riprovare.');
        }

        return redirect('admin/users')->with('success_message', 'Editor invitato correttamente.');
    }

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
}
