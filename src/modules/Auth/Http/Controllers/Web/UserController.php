<?php

namespace Modules\Auth\Http\Controllers\Web;

use Modules\Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Modules\Auth\Constants\AuthConst;
use Modules\Auth\Entities\Mail\NewAccount;
use Modules\Auth\Entities\Models\Role;
use Modules\Auth\Entities\Models\User;
use Modules\Auth\Http\Requests\UserRequest;
use Modules\Auth\Services\UserService;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $assign = [
            'users' => $this->userService->paginate(['with_load' => ['roles']]),
            'roles' => $this->userService->getRoles()
        ];

        return view('auth::user.index', $assign);
    }

    public function search()
    {
        $assign = [
            'users' => $this->userService->ajaxSearch(
                ['with_load' => ['roles']],
                (request()->get('per_page') ?? $this->userService::PAGE_LIMIT)
            ),
            'roles' => $this->userService->getRoles()
        ];

        return view('auth::user.index', $assign);
    }

    public function ajaxSearch()
    {
        $assign['list'] = $this->userService->ajaxSearch([], 30);

        return json_encode($assign['list']);
    }

    public function backToMainUser()
    {
        if (Session::get('adminId')) {
            Auth::loginUsingId(Session::get('adminId'));

            return redirect()->route('cp.users.index');
        }

        return redirect()->route('cp');
    }

    public function loginAsUser(User $user)
    {
        Auth::loginUsingId($user->id);

        return redirect()->route('cp');
    }

    public function create()
    {
        $assign['roles'] = Role::all();

        return view('auth::user.create', $assign);
    }

    public function store(UserRequest $request)
    {
        $data             = $request->only(
            ['name', 'email', 'password', 'avatar', 'phone_number', 'address', 'status']
        );
        $email            = $data['email'];
        $password         = $data['password'] ?? $this->userService->makePassword();
        $data['password'] = Hash::make($data['password']);

        /* @var $user User */
        $user = $this->userService->create($data);

        if (!empty($user)) {
            $user->assignRole($request->get('role_id'));
            activity()->send(new NewAccount($email, $password));

            return redirect()->route('cp.users.index')
                ->with('success', trans('core::message.notify.create success'));
        }

        return redirect()->route('cp.users.index');
    }

    public function show($id)
    {
        /* @var $assign ['user'] User */
        $assign['user'] = $this->userService->findOr404($id);

        $assign['roles'] = Role::all();
        $assign['user']->loadMissing('roles');

        return view('auth::user.show', $assign);
    }

    public function edit($id)
    {
        /* @var $assign ['user'] User */
        $assign['user'] = $this->userService->findOr404($id);

        $assign['roles'] = Role::all();
        $assign['user']->loadMissing('roles');

        return view('auth::user.edit', $assign);
    }

    public function update($id, UserRequest $request)
    {
        $assign['user'] = $this->userService->findOr404($id);
        $data           = $request->only(['name', 'password', 'avatar', 'phone_number', 'address', 'status']);

        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (!isset($data['avatar'])) {
            unset($data['avatar']);
        }

        $user = $this->userService->update($id, $data);

        if (is_array($request->get('role_id'))) {
            $roles = $request->get('role_id');
        } else {
            $roles = [$request->get('role_id')];
        }
        $roleIds = array_filter($roles, function ($value) {
            return !is_null($value) && $value !== '';
        });

        $user->roles()->sync($roleIds);

        return redirect()->route('cp.users.index')
            ->with('success', trans('core::message.notify.update success'));
    }

    public function destroy($id)
    {
        $assign['user'] = $this->userService->findOr404($id);
        $assign['user']->loadMissing('roles');

        if (!in_array(AuthConst::ROLE_SUPER_ADMIN, $assign['user']->roles->pluck('name')->toArray())) {
            $assign['user']->delete();
        }

        return redirect()->route('cp.users.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $assign['user'] = $this->userService->findOr404($id);
        $assign['user']->loadMissing('roles');
        $data           = $request->only('status');
        $data['status'] = (bool)$data['status'] ? 1 : 0;

        if (!in_array(AuthConst::ROLE_SUPER_ADMIN, $assign['user']->roles->pluck('name')->toArray())) {
            $assign['user']->update($data);

            return response()->json([
                'status'  => 'success',
                'message' => trans('core::message.notify.update success'),
            ]);
        }

        return response()->json([
            'status'  => 'fail',
            'message' => trans('core::message.notify.update fail'),
        ]);
    }
}
