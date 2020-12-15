<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;

class UserController extends ApiController
{
    protected $user;

    public function __construct()
    {
        try {
            $this->user = Auth::userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['user_not_found'], 404);
        }
    }

    /**
     * List of users (for demo)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respond(User::all());
    }

    /**
     * Create new user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:32',
            'password' => 'required|min:5|max:32',
            'name' => 'required|min:5|max:32',
        ]);

        $user_data = $request->only(['email', 'name']);
        $user_data['password'] = Hash::make($request->get('password'));

        try {
            User::create($user_data);
            return response('registration success', 201);
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){
                return response('duplicate entry', 409);
            } else {
                return response($e->getMessage(), 500);
            }
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }
}
