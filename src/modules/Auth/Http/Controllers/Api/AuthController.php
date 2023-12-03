<?php

namespace Modules\Auth\Http\Controllers\Api;

use Modules\Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\UserRequest;
use Modules\Organization\Http\Resources\CompanyResources;

class AuthController extends Controller
{
    public function login(UserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response([
                'status' => 'error',
                'error'  => 'invalid.credentials',
                'msg'    => 'Invalid Credentials.'
            ], 400);
        }

        $userData = auth('api')->user();

        return response([
            'status' => 'success',
            'token'  => $token,
            'user'  => [
                'id' => $userData->id,
                'name' => $userData->name,
                'email' => $userData->email,
                'roles'    =>  $userData->roles->pluck('name')->toArray(),
                'campaign_id' => $userData->detail->company->campaign->id ?? null
            ],

        ])->header('Authorization', $token);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function user()
    {
        $userData = auth('api')->user();
        $userData->loadMissing(['roles', 'detail.company']);

        return response(
            [
                'status' => 'success',
                'data'   => [
                    'id' => $userData->id,
                    'email'    => $userData->email,
                    'name'     => $userData->name,
                    'phone_number' => $userData->phone_number,
                    "company" => $userData->detail->company ? new CompanyResources($userData->detail->company) : null,
                    'roles'    => $userData->roles->pluck('name')->toArray(),
                    'campaign_id' => $userData->detail->company->campaign->id ?? null
                ]
            ]
        );
    }
}
