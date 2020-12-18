<?php

namespace App\Http\Controllers\Auth;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTAuth;
use App\User;

class AuthController extends BaseController
{
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * @api     : auth/login
     * @param   : email
     *          : password
     * @return  : access token object or 401,500
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            $token = $this->jwt->attempt($request->only('email', 'password'));
            if (!$token) {
                return response('user not found', 401);
            }
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @api     : auth/refresh
     * @return  : access token object
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * @api     : auth/logout
     * @return  : access token object
     */
    public function logout()
    {
        Auth::logout();
        return response('', 205);
    }

    /**
     * @api     : auth/me
     * @return  : user object
     */
    public function me()
    {
        $this->user = Auth::userOrFail();
        return response($this->user->toArray());
    }

    /**
     * Formats token with expiry time
     *
     * @param   : token
     * @return  : access token object
     */
    private function respondWithToken($token)
    {
        // get epoch time of expiry
        $time = time();
        $expiry = $time + (Auth::factory()->getTTL() * 60);
        $expiry_iso = date("Y-m-d\TH:i:sO", $expiry);

        return response()->json([
            'access_token'     => $token,
            'expires_in_epoch' => $expiry,
            'expires_in_iso'   => $expiry_iso,
        ]);
    }
}
