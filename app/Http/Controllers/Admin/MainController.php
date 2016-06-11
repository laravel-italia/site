<?php

namespace LaravelItalia\Http\Controllers\Admin;

use \Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use LaravelItalia\Domain\Repositories\UserRepository;
use LaravelItalia\Domain\User;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Http\Requests\UserLoginRequest;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getLogin', 'postLogin', 'getInvitation', 'postInvitation']]);
        $this->middleware('role:editor,administrator', ['except' => ['getLogin', 'postLogin', 'getInvitation', 'postInvitation']]);
    }

    public function getIndex()
    {
        return redirect('admin/dashboard');
    }

    public function getDashboard()
    {
        return view('admin.dashboard');
    }

    public function getLogin()
    {
        return view('admin.login');
    }

    public function postLogin(UserLoginRequest $request)
    {
        if(Auth::attempt(array_merge($request->except('_token'), ['is_confirmed' => true, 'is_blocked' => false]), true)) {
            return redirect('admin/dashboard');
        } else {
            return redirect('admin/login')->with('errors', Collection::make(['Credenziali non corrette. Riprovare.']));
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('admin/login')->with('message', 'Logout effettuato. A presto!');
    }

    public function getInvitation(UserRepository $userRepository, $confirmationCode)
    {
        if(!$userRepository->findByConfirmationCode($confirmationCode)){
            return redirect('admin/login')->with('errors', Collection::make(['Codice di conferma non riconosciuto. Riprovare.']));
        }

        return view('admin.editor_signup', ['confirmationCode' => $confirmationCode]);
    }

    public function postInvitation(Request $request, UserRepository $userRepository, $confirmationCode)
    {
        /* @var User $user */
        $user = $userRepository->findByConfirmationCode($confirmationCode);

        if(!$user){
            return redirect('admin/login')->with('errors', Collection::make(['Codice di conferma non riconosciuto. Riprovare.']));
        }

        if($user->email !== $request->get('email')) {
            return redirect('admin/invitation/' . $confirmationCode)->with('errors', Collection::make(['L\'indirizzo email inserito non corrisponde a quello del codice.']));
        }

        $user->setNewPassword($request->get('password'));
        $user->confirm();

        try {
            $userRepository->save($user);
        } catch (NotSavedException $e) {
            return redirect('admin/invitation/' . $confirmationCode)->with('errors', Collection::make(['Problemi in fase di salvataggio della password. Riprovare.']));
        }

        return redirect('admin/login')->with('message', 'Editor registrato! Effettua l\'accesso inserendo le credenziali scelte.');
    }
}
