<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Entities\Repositories\RoleRepository;
use LaravelItalia\Entities\Repositories\UserRepository;

/**
 * Class UserController.
 */
class UserController extends Controller
{
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
}
