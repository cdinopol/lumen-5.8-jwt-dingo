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

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:32',
            'password' => 'required|min:5|max:32',
        ]);

        $user_data = $request->only('email');
        $user_data['password'] = Hash::make($request->get('password'));

        try {
            User::create($user_data);
            return response('registration success', 201);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return response('duplicate entry', 409);
            } else {
                return response('', 500);
            }
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

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
