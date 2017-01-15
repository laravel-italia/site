<?php

namespace LaravelItalia\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use JildertMiedema\LaravelTactician\DispatchesCommands;
use LaravelItalia\Domain\Commands\AssignRoleToUserCommand;
use LaravelItalia\Domain\Repositories\RoleRepository;
use LaravelItalia\Domain\Repositories\UserRepository;
use LaravelItalia\Domain\User;
use LaravelItalia\Exceptions\NotFoundException;

class DiscourseSSOController extends Controller
{
    use DispatchesCommands;

    /**
     * Rimanda l'utente al forum, per avviare la procedura di accesso.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getRedirect()
    {
        return redirect('http://forum.laravel-italia.it/session/sso_provider?' . $this->getRedirectRequestQuery());
    }

    /**
     * Riceve un payload relativo all'utente che ha effettuato l'operazione di accesso. Se va tutto bene, l'utente
     * viene automaticamente registrato e viene effettuato l'accesso. Se già presente, l'utente non verrà aggiunto
     * nuovamente ma verrà effettuato soltanto il login.
     *
     * @param Request $request
     * @param Store $session
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getCallback(Request $request, Store $session, UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $userData = $this->getDiscourseUserData($request);
        $intended = $session->pull('intended', '/');

        try {
            $user = $userRepository->findByEmail($userData['email']);
            if($user->role->name === 'user') {
                Auth::login($user);
            }

            return redirect($intended);

        } catch (NotFoundException $e) {
            $user = User::fromDiscourseUserNameAndEmail(
                $userData['name'],
                $userData['email']
            );

            try {
                $role = $roleRepository->findByName('user');
                $this->dispatch(new AssignRoleToUserCommand($role, $user));
                $userRepository->save($user);
                Auth::login($user);
                return redirect($intended);

            } catch (\Exception $e) {
                return view('errors.500');
            }
        }
    }

    /**
     * Effettua il logout dell'utente attuale.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * Prepara la query string da mandare al forum Discourse.
     *
     * @return string
     */
    private function getRedirectRequestQuery()
    {
        $nonce = 27;
        $sso_secret = env('FORUM_SSO_SECRET');

        $payload = base64_encode(http_build_query([
                'nonce' => $nonce,
                'return_sso_url' => url('sso/callback')
            ]
        ));

        $request = [
            'sso' => $payload,
            'sig' => hash_hmac('sha256', $payload, $sso_secret)
        ];

        return http_build_query($request);
    }

    /**
     * Si occupa di restituire l'array con i dati dell'utente, da usare per l'operazione di verifica/registrazione.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function getDiscourseUserData(Request $request)
    {
        $nonce = 27;
        $sso_secret = env('FORUM_SSO_SECRET');

        $sso = $request->get('sso');
        $sig = $request->get('sig');

        if(hash_hmac('sha256', urldecode($sso), $sso_secret) !== $sig){
            return view('errors.500');
        }

        $sso = urldecode($sso);
        $userData = [];
        parse_str(base64_decode($sso), $userData);

        if($userData['nonce'] != $nonce) {
            return view('errors.500');
        }

        return $userData;
    }
}
