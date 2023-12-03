<?php

namespace Modules\Auth\Http\Controllers\Web;

use Modules\Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Services\UserService;

class ProfileController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function profile()
    {
        $assign['profile'] = $this->userService->find(auth()->user()->id);

        return view('auth::profile.edit', $assign);
    }

    public function update(Request $request)
    {
        $user = $this->userService->find(auth()->user()->id);
        $data = $request->only(['name', 'password']);

        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $this->userService->update($user->id, $data);

        return redirect()->route('cp.profile');
    }
}
