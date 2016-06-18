<?php

namespace LaravelItalia\Http\Controllers\Admin;

use \Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Intervention\Image\Exception\NotFoundException;
use JildertMiedema\LaravelTactician\DispatchesCommands;
use LaravelItalia\Domain\Commands\RecoveryPasswordCommand;
use LaravelItalia\Domain\Commands\ResetPasswordCommand;
use LaravelItalia\Domain\Repositories\PasswordResetRepository;
use LaravelItalia\Domain\Repositories\UserRepository;
use LaravelItalia\Domain\User;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Http\Requests\UserLoginRequest;
use LaravelItalia\Http\Requests\UserPasswordRecoveryRequest;
use LaravelItalia\Http\Requests\UserPasswordResetRequest;

class MainController extends Controller
{
    use DispatchesCommands;

    public function __construct()
    {
        $methods = ['getLogin', 'postLogin', 'getInvitation', 'postInvitation', 'getRecovery', 'postRecovery', 'getReset', 'postReset'];

        $this->middleware('auth', ['except' => $methods]);
        $this->middleware('role:editor,administrator', ['except' => $methods]);
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

    public function getRecovery()
    {
        return view('admin.recovery');
    }

    public function postRecovery(UserPasswordRecoveryRequest $request, UserRepository $userRepository)
    {
        $user = $userRepository->findByEmail($request->get('email'));

        if(!$user) {
            return redirect('admin/recovery')->with('errors', Collection::make(['Nessun utente corrispondente all\'indirizzo specificato.']));
        }

        $this->dispatch(new RecoveryPasswordCommand($user));

        return redirect('admin/recovery')->with('message', 'Riceverai presto una mail con tutti i dettagli per scegliere una nuova password.');
    }

    public function getReset($token = null)
    {
        if(!$token) {
            return redirect('admin/login');
        }

        return view('admin.reset', compact('token'));
    }

    public function postReset(UserPasswordResetRequest $request, UserRepository $userRepository)
    {
        try {
            $user = $userRepository->findByEmail($request->get('email'));

            $this->dispatch(new ResetPasswordCommand(
                $user,
                $request->get('tgit oken'),
                $request->get('password')
            ));

            Auth::login($user);
            return redirect('admin/dashboard');

        } catch (NotFoundException $e) {
            return redirect('admin/reset/' . $request->get('token'))->with('errors', Collection::make(['Problemi in fase di ricerca dell\'utente specificato. Riprovare.']));
        } catch (\Exception $e) {
            return redirect('admin/reset/' . $request->get('token'))->with('errors', Collection::make(['Problemi in fase di salvataggio della nuova password. Riprovare.']));
        }
    }
}
