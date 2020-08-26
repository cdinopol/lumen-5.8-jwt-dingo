<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class UserController extends ApiController
{
    protected $user;
    /*
    * create conroller instance, set user
    */
    public function __construct()
    {
        try {
            $this->user = Auth::userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['user_not_found'], 404);
        }
    }

    public function list()
    {
        return $this->respond(User::all());
    }

    public function me()
    {
        return $this->respond($this->user->toArray());
    }
}
