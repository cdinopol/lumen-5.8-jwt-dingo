<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Auth;

class ApiController extends BaseController
{
    protected $user;

    private $statusCode;

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

        // set default
        $this->statusCode = 200;
    }

    /*
    * set status code
    */
    protected function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;
		return $this;
	}

    /*
    * standard response
    */
    protected function respond($data, $headers = [])
    {
    	return response()->json($data, $this->statusCode, $headers);
    }

    /*
    * successful create, update, delete operations
    */
    protected function respondSuccess($message, $data = [])
	{
		return $this->setStatusCode(201)->respond([
			'message' => $message,
			'data' => $data
		]);
	}

	/*
    * failed create, update, delete operations
    */
    protected function respondFailed($message, $data = [])
	{
		return $this->setStatusCode(202)->respond([
			'message' => $message,
			'data' => $data
		]);
	}

	/*
    * invalid input format
    */
	protected function respondError($message)
	{
		return $this->setStatusCode(422)->respond([
			'message' => $message,
			'data' => ""
		]);
	}
}
